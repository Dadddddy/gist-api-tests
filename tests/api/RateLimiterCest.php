<?php 

class RateLimiterCest
{
    public function non_authorised_user_exceeds_rate_limiter(ApiTester $I){

        $I->wantToTest("gists rate limiter");
        $I->sendGET(getenv("GIST_BASE_URL")."/rate_limit");
        $I->seeResponseCodeIs(200);
        $response= json_decode($I->grabResponse(),true);
        for($j=0; $j<$response['resources']['core']['remaining']; $j ++){

            $I->sendGET(getenv("GIST_BASE_URL")."/users/".getenv("GIST_USER")."/gists");
            $I->seeResponseCodeIs(200);

        }
        $I->sendGET(getenv("GIST_BASE_URL")."/users/".getenv("GIST_USER")."/gists");
        $I->seeResponseCodeIs(403);
        
    }
    public function authorised_user_exceeds_rate_limiter(ApiTester $I){

        $I->wantToTest("gists rate limiter");
        $I->haveHttpHeader("Authorization","Token ".getenv("OAUTH_TOKEN"));
        $I->sendGET(getenv("GIST_BASE_URL")."/rate_limit");
        $I->seeResponseCodeIs(200);
        $response= json_decode($I->grabResponse(),true);
        for($j=0; $j<$response['resources']['core']['remaining']; $j ++){

            $I->sendGET(getenv("GIST_BASE_URL")."/users/".getenv("GIST_USER")."/gists");
            $I->seeResponseCodeIs(200);

        }
        $I->sendGET(getenv("GIST_BASE_URL")."/users/".getenv("GIST_USER")."/gists");
        $I->seeResponseCodeIs(403);

    }
}
