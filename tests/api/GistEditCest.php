<?php 

class GistEditCest
{
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
    }
}
