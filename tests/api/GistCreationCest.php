<?php 

class GistCreationCest
{
    /**
     * @param ApiTester $I
     */
    public function non_authorised_user_tries_to_create_a_gist_and_fails(ApiTester $I){

        $I->sendPOST(getenv("GIST_BASE_URL")."/gists", [
            'description' => "Hello World Examples",
            'public' => true,
            'files' =>[
                'hello_world.py' => [
                    'content' => "class HelloWorld:\n\n    def __init__(self, name):\n        self.name = name.capitalize()\n       \n    def sayHi(self):\n        print \"Hello \" + self.name + \"!\"\n\nhello = HelloWorld(\"world\")\nhello.sayHi()"
                ]
            ]
        ]);
        $I->seeResponseCodeIs(401);
        $response= json_decode($I->grabResponse(),true);
        $I->assertEquals("Requires authentication", $response['message']);

    }

    public function authorised_user_tries_to_create_a_gist_and_succeed(ApiTester $I){

        $description="Hello World Examples";
        $I->haveHttpHeader("Content-Type", "application/json");
        $I->haveHttpHeader("Authorization","Token ".getenv("OAUTH_TOKEN"));
        $I->sendPOST(getenv("GIST_BASE_URL")."/gists", [
            'description' => $description,
            'public' => true,
            'files' =>[
                'hello_world.py' => [
                    'content' => "class HelloWorld:\n\n    def __init__(self, name):\n        self.name = name.capitalize()\n       \n    def sayHi(self):\n        print \"Hello \" + self.name + \"!\"\n\nhello = HelloWorld(\"world\")\nhello.sayHi()"
                ]
            ]
        ]);
        $I->seeResponseCodeIs(201);
        $response= json_decode($I->grabResponse(),true);
        $I->assertEquals($description, $response['description']);

    }
}
