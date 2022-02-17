<?php

namespace App\Traits;
use Illuminate\Support\Facades\Http;
use Google_Client;
use Google_Service_AndroidPublisher;

trait Subscriptions{

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function verifyAndroidRecipet($prodID, $purchToken){
        $jsonKey = [
            "type"=> "service_account",
            "project_id"=> "pc-api-7711486445957378314-256",
            "private_key_id"=> "d045f9272a468819bfcbff171149149558a5b8fd",
            "private_key"=> "-----BEGIN PRIVATE KEY-----\nMIIEvQIBADANBgkqhkiG9w0BAQEFAASCBKcwggSjAgEAAoIBAQDSinf7BM064jUN\nvhDofhzWcN/hI/qt7QRB2v8O6mWH0Ci7J2ixMZmbpw+pQ8NxU1K7Cctw2S1XMllK\nJUi7jtziLrokJDOCHNcASA9ZcHY3pBhNttIodnpWFZTQo1fQxWCE8+1JVDJhe/+a\nxbnX9TruRKnimhmo1uh4djHryZ2Sr9TdwIXA7ihHUPNPnx5VNIkJlYkdpHqmBIvs\nVLoqJTRWeAT0Cf87eH34lDsHpM/a6bo18wfxtg93oUuh0zkOpPhyEsSDYP9fFWym\nnfUuwMDF6DFaSwpDKszyW9sQsS94iHFX3rdHDS76Z2Kcf4dxWWQGqadh8ZwUmpUA\nS5KvY+J3AgMBAAECggEAA1ghucIExIetUg+P0zGVoa5fUAMzSyn1pFonLQR6ImMj\nEn34wr/H8doAfK7P3u/043WvXpaEitsI4g2fjyMgzRLy7/oHO2zb2WxLmh8YMaAQ\npsNdqTjgjpd/KqU9ktpfwxzgywZkWnoOwFWdsxl5GynKDQhnme/391nhRx6Huzm6\nYPoVK7JM9KB25HXUrFXemXl97r3WdtT+iCEwPVBHR646akON35OaOaBpJ+H5I5ty\nTVnGbRWEhwYyyGnRoK3ssFiJtpSAB7E2uzo4YQAWJzolXOBnmcZQVbr9smttFckV\nqLp7ETMv5JhoPPqtAleo5goepypfyOgFH1hx8xFsmQKBgQD7DD/oz7iso8vWUsNg\nyfjBKbAh7jA/EtQQ9mN3W1Krw/CzahcTE3uZbzzk3K52h4ZQGXZ1qZMnJS+mSir2\n6BCbzjQ98pYxbzLKnwIdHMdcnFCvyFcKL5FFm6CEbnSUSKAUQV6/qWaY85pPEQkE\nfLhJwMFSsI0BR6HJUKcdODhfcwKBgQDWsaph+fIv6f6281Xts+wemUuaxUYyEL2M\nJPtAt5QroCzMIXELWwWMcRW66/nJUkK60nJMOt7iSWmT+k59DGBh+9oVqRXntgjk\nUaRNUY1lUJ5+Hyq49ltI3WoUoHwst9u2ZuFmmmQqXkYbz5prGNxPOCG0h9OGkQQZ\nzEZyJHMn7QKBgH9ZZm4WOUsyR+uvzjaiHhL2r8d2iXjldzgnlKtuYxCI8+g/b/cY\nUgGygQRjwgiUlRi64fGsFN6tqW9EfmkDrbEruCqYjYIEM5K/eJYGDEe5b+DL0wNy\nv9G8sX+cfHzgHnxH8OVu7IG4SVXEgXuKPP4EzszAjLbSfIqf5DYZV9drAoGBAICh\nB4UV/F1qo3o3RldZQfF/RMXgxdK/JuFtUr+OfY65s71Fl/YGvcdMBYntUcWlrGdE\nKMi1SM5oz4GiKR5QqPprq1jo6j/eV2t74qWUY9O8voiv4afZqg144tKi6GLecRvS\nfd88RyD/RJ/q/QiHZ49rAP6pljj8b2mJcvd2ESxtAoGAKjmo8aSWgpMI7huger0o\nZoEz8KxDPD3K1nnutCMDecF6aapblyEgXXU8Qc80eBCqwq2tha+vLyIkpm9y2iG7\ntYK/ssZOh2eEJxbOanUj9BEQZ91I75t7MFb+1CCkbu7nm2jrJaCL/qR2YqswTUiw\n3QFzgm4qb+T0JmXj4nG/5Qc=\n-----END PRIVATE KEY-----\n",
            "client_email"=> "rtl-service-acc@pc-api-7711486445957378314-256.iam.gserviceaccount.com",
            "client_id"=> "108756846277127061429",
            "auth_uri"=> "https://accounts.google.com/o/oauth2/auth",
            "token_uri"=> "https://oauth2.googleapis.com/token",
            "auth_provider_x509_cert_url"=> "https://www.googleapis.com/oauth2/v1/certs",
            "client_x509_cert_url"=> "https://www.googleapis.com/robot/v1/metadata/x509/rtl-service-acc%40pc-api-7711486445957378314-256.iam.gserviceaccount.com"
        ];

        $client = new Google_Client();
        $client->setAuthConfig($jsonKey);
        $client->addScope(Google_Service_AndroidPublisher::ANDROIDPUBLISHER);

        $token = $client->fetchAccessTokenWithAssertion()['access_token'];

        $res = Http::withHeaders([
            'Authorization' => 'Bearer '.$token
        ])->get("https://androidpublisher.googleapis.com/androidpublisher/v3/applications/store.readtolead.rtl/purchases/subscriptions/".$prodID."/tokens/".$purchToken);

        if($res->failed()){
            return [];
        }
        return $res;
    }

    public function verifyIosReceipt($receipt){
//        return Str::uuid();
//        return $response = Http::get('https://api.storekit.itunes.apple.com/inApps/v1/subscriptions/1000000962527547');

        $data = json_decode($receipt, true);
        if($data['platform'] == 'ios'){
            // todo: change sandbox to buy
            $response = Http::post('https://buy.itunes.apple.com/verifyReceipt', [
                'receipt-data'              => $data['receiptData'],
                'password'                  => 'b5223934a0d649ffa594bd0ec7100e30',
                'exclude-old-transactions'  => true
            ]);

            return json_decode($response, true);
        }
        return [];
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function verifySubscription($subscriptionData, $platform){
        $resp = [];

        if($platform == 'android'){
            $subscriptionData = json_decode($subscriptionData,true);
            $data = $this->verifyAndroidRecipet($subscriptionData['productId'], $subscriptionData['purchaseToken']);

            $mil = $data['expiryTimeMillis'];
            $seconds = $mil / 1000;
            $ex= date("d-m-Y H:i:s", $seconds);

            $resp['is_renewable']       =  $data['autoRenewing'];
            $resp['expiration_date']    =  $ex;
            $resp['order_id']           =  $subscriptionData['orderId'];
            return $resp;
        }elseif ($platform == 'ios'){
            $data = $this->verifyIosReceipt($subscriptionData);
            $subscriptionData           = json_decode($subscriptionData,true);
            $resp['is_renewable']       =  $data['pending_renewal_info'][0]['auto_renew_status'];
            $resp['expiration_date']    =  $data['latest_receipt_info'][0]['expires_date'];
            $resp['order_id']           =  $subscriptionData['orderId'];
            return $resp;
        }
    }
}
