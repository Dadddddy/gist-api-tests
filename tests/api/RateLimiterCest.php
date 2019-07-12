<?php 

class RateLimiterCest
{
    public function gist_rate_rimiter_test(ApiTester $user){

        $user->wantToTest("gists rate limiter");
        $user->sendGET(getenv("GIST_BASE_URL"));
        $user->seeResponseCodeIs(200);


    }
}
