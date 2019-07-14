<?php 

class GistEditCest
{
    public function _before(ApiTester $I){

        $I->haveHttpHeader("Authorization","Token ".getenv("OAUTH_TOKEN"));
        $I->sendGET(getenv("GIST_BASE_URL")."/users/".getenv("GIST_USER")."/gists");
        $I->seeResponseCodeIs(200);
        $response= json_decode($I->grabResponse(),true);
        for($j = 0; $j<count($response); $j++){
            $I->sendDELETE(getenv("GIST_BASE_URL")."/gists/".$response[$j]['id']);
        }
        $I->deleteHeader("Authorization");

    }
    public function non_authorised_user_tries_to_edit_a_gist_and_fails(ApiTester $I){

        $I->haveHttpHeader("Content-Type", "application/json");
        $I->haveHttpHeader("Authorization","Token ".getenv("OAUTH_TOKEN"));
        $I->sendPOST(getenv("GIST_BASE_URL")."/gists", [
            'description' => "hello world example",
            'public' => true,
            'files' =>[
                'hello_world.py' => [
                    'content' => "class HelloWorld:\n\n    def __init__(self, name):\n        self.name = name.capitalize()\n       \n    def sayHi(self):\n        print \"Hello \" + self.name + \"!\"\n\nhello = HelloWorld(\"world\")\nhello.sayHi()"
                ]
            ]
        ]);
        $I->seeResponseCodeIs(201);
        $response= json_decode($I->grabResponse(),true);
        $I->deleteHeader('Authorization');
        $I->sendPATCH(getenv("GIST_BASE_URL")."/gists/".$response['id'],[
            'description' => "edited - hello world",
            'files' => [
                'hello_world.py' => [
                    'content' => "#This file is edited\n\nclass HelloWorld:\n\n    def __init__(self, name):\n        self.name = name.capitalize()\n       \n    def sayHi(self):\n        print \"Hello \" + self.name + \"!\"\n\nhello = HelloWorld(\"world\")\nhello.sayHi()",
                    'filename' => "edited_hello_world.py"
                ]
            ]
        ]);
        $I->seeResponseCodeIs(404);
        $response= json_decode($I->grabResponse(),true);
        $I->assertEquals("Not Found", $response['message']);

    }

    public function authorised_user_tries_to_edit_a_gist_and_succeeds(ApiTester $I){

        $I->haveHttpHeader("Content-Type", "application/json");
        $I->haveHttpHeader("Authorization","Token ".getenv("OAUTH_TOKEN"));
        $I->sendPOST(getenv("GIST_BASE_URL")."/gists", [
            'description' => "hello world example",
            'public' => true,
            'files' =>[
                'hello_world.py' => [
                    'content' => "class HelloWorld:\n\n    def __init__(self, name):\n        self.name = name.capitalize()\n       \n    def sayHi(self):\n        print \"Hello \" + self.name + \"!\"\n\nhello = HelloWorld(\"world\")\nhello.sayHi()"
                ]
            ]
        ]);
        $I->seeResponseCodeIs(201);
        $response= json_decode($I->grabResponse(),true);
        $description= "edited - hello world";
        $content="#This file is edited\n\nclass HelloWorld:\n\n    def __init__(self, name):\n        self.name = name.capitalize()\n       \n    def sayHi(self):\n        print \"Hello \" + self.name + \"!\"\n\nhello = HelloWorld(\"world\")\nhello.sayHi()";
        $filename="edited_hello_world.py";
        $I->sendPATCH(getenv("GIST_BASE_URL")."/gists/".$response['id'],[
            'description' => $description,
            'files' => [
                'hello_world.py' => [
                    'content' => $content,
                    'filename' => $filename
                ]
            ]
        ]);
        $I->seeResponseCodeIs(200);
        $response= json_decode($I->grabResponse(),true);
        $I->assertEquals($description, $response['description']);
        $I->assertEquals($content, $response['files'][$filename]['content']);
        $I->assertEquals($filename, $response['files'][$filename]['filename']);

    }


    public function _after(ApiTester $I){

        $I->haveHttpHeader("Authorization","Token ".getenv("OAUTH_TOKEN"));
        $I->sendGET(getenv("GIST_BASE_URL")."/users/".getenv("GIST_USER")."/gists");
        $I->seeResponseCodeIs(200);
        $response= json_decode($I->grabResponse(),true);
        for($j = 0; $j<count($response); $j++){
            $I->sendDELETE(getenv("GIST_BASE_URL")."/gists/".$response[$j]['id']);
        }
        $I->deleteHeader("Authorization");
    }
}
