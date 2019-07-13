<?php 

class GistDeleteCest
{
    public function _before(ApiTester $I)
    {
        $I->haveHttpHeader("Authorization","Token ".getenv("OAUTH_TOKEN"));
        $I->sendGET(getenv("GIST_BASE_URL")."/users/".getenv("GIST_USER")."/gists");
        $I->seeResponseCodeIs(200);
        $response= json_decode($I->grabResponse(),true);
        for($j = 0; $j<count($response); $j++){
            $I->sendDELETE(getenv("GIST_BASE_URL")."/gists/".$response[$j]['id']);
        }
        $I->deleteHeader("Authorization");

    }

    public function authorised_user_tries_to_delete_a_gist_and_succeeds(ApiTester $I){

        $I->haveHttpHeader("Authorization","Token ".getenv("OAUTH_TOKEN"));
        $I->haveHttpHeader("Content-Type", "application/json");
        $I->sendPOST(getenv("GIST_BASE_URL")."/gists", [
            'description' => "Hello World Examples",
            'public' => true,
            'files' =>[
                'hello_world.py' => [
                    'content' => "class HelloWorld:\n\n    def __init__(self, name):\n        self.name = name.capitalize()\n       \n    def sayHi(self):\n        print \"Hello \" + self.name + \"!\"\n\nhello = HelloWorld(\"world\")\nhello.sayHi()"
                ]
            ]
        ]);
        $I->seeResponseCodeIs(201);
        $response= json_decode($I->grabResponse(),true);
        $I->sendDELETE(getenv("GIST_BASE_URL")."/gists/".$response['id']);
        $I->seeResponseCodeIs(204);
        $I->sendGET(getenv("GIST_BASE_URL")."/users/".getenv("GIST_USER")."/gists");
        $I->seeResponseCodeIs(200);
        $response1= json_decode($I->grabResponse(),true);
        $I->assertEquals(0,count($response1));
    }
    public function non_authorised_user_tries_to_delete_a_gist_and_fails(ApiTester $I){

        $I->haveHttpHeader("Authorization","Token ".getenv("OAUTH_TOKEN"));
        $I->haveHttpHeader("Content-Type", "application/json");
        $I->sendPOST(getenv("GIST_BASE_URL")."/gists", [
            'description' => "Hello World Examples",
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
        $I->sendDELETE(getenv("GIST_BASE_URL")."/gists/".$response['id']);
        $I->seeResponseCodeIs(404);
        $response= json_decode($I->grabResponse(),true);
        $I->assertEquals("Not Found", $response['message']);

    }

}
