<img src="https://www.sipgatedesign.com/wp-content/uploads/wort-bildmarke_positiv_2x.jpg" alt="sipgate logo" title="sipgate" align="right" height="112" width="200"/>

# sipgate.io php send sms example

To demonstrate how to send a SMS, we queried the `/sessions/sms` endpoint of the sipgate REST API.

For further information regarding the sipgate REST API please visit https://api.sipgate.com/v2/doc

### Prerequisites

- [composer](https://getcomposer.org)
- php >= 7.0

### How to use

Navigate to the project's root directory.

Install dependencies manually or use your IDE's import functionality:

```bash
$ composer install
```

Create the `.env` by copying the [`.env.example`](.env.example) and set the values according to the comment above each variable.

The token should have the `sessions:sms:write` scope. For more information about personal access tokens visit https://www.sipgate.io/rest-api/authentication#personalAccessToken.

The `SMS_ID` uniquely identifies the extension from which you wish to send your message. Further explanation is given in the section [Web SMS Extensions](#web-sms-extensions).

> **Optional:**
> In order to send a delayed message uncomment the following line in [SendSms.php](./src/SendSms.php) and set the desired date and time in the future (up to one month):
>
> ```php
> $client->sendAt($message, $recipient, $smsId, time() + 60);
> ```
>
> **Note:** The `sendAt` property in the `SMS` object is a [Unix timestamp](https://www.unixtimestamp.com/).

### Run the application

Install dependencies

```bash
$ composer install
```

Run the application:

```bash
$ php -f src/SendSms.php
```

### How it works

The sipgate REST API is available under the following base URL:

```php
protected static $BASE_URL = "https://api.sipgate.com/v2/";
```

The API expects request data in JSON format. Thus the `Content-Type` header needs to be set accordingly. You can achieve that by using the `withHeaders` method from the `Zttp` library.

```php
protected function send(Sms $sms): ZttpResponse
{
    return Zttp::withHeaders([
            "Accept" => "application/json",
            "Content-Type" => "application/json"
        ])
        ->withBasicAuth($this->tokenId, $this->token)
        ->post(self::$BASE_URL . "sessions/sms", $sms->toArray());
}
```

The request body contains the `SMS` object, which has four fields: `smsId`, `recipient`, `message` and an optional `sendAt` specified above.

```php
class Sms {
    protected $smsId;
    protected $message;
    protected $recipient;
    protected $sendAt;

    public function __construct($smsId, $message, $recipient, $sendAt = null)
    {
        $this->smsId = $smsId;
        $this->message = $message;
        $this->recipient = $recipient;
        $this->sendAt = $sendAt;
    }

    ...

}
```

We use the package `Zttp` for request generation and execution. The `post` method takes the request URL and the requests body payload as arguments. Headers and authorization header are generated from `withHeaders` and `withBasicAuth` methods respectively. The request URL consists of the base URL defined above and the endpoint `/sessions/sms`. The method `withBasicAuth` from the `Zttp` package takes credentials and generates the required Basic Auth header (for more information on Basic Auth see our [code example](https://github.com/sipgate-io/sipgateio-basicauth-java)).

> If OAuth should be used for `Authorization` instead of Basic Auth we do not use the `withBasicAuth(tokenId, token)` method. Instead we set the authorization header to `Bearer` followed by a space and the access token: `Zttp::withHeaders(["Authorization" => "Bearer " . accessToken])`. For an example application interacting with the sipgate API using OAuth see our [sipgate.io Java Oauth example](https://github.com/sipgate-io/sipgateio-oauth-java).

#### Send SMS with custom sender number

By default 'sipgate' will be used as the sender. It is only possible to change the sender to a mobile phone number by verifying ownership of said number. In order to accomplish this, proceed as follows:

1. Log into your [sipgate account](https://app.sipgate.com/connections/sms)
2. Click **SMS** in the sidebar (if this option is not displayed you might need to book the **Web SMS** feature from the Feature Store)
3. Click the gear icon on the right side of the **Caller ID** box and enter the desired sender number.
4. Proceed to follow the instructions on the website to verify the number.

### Web SMS Extensions

A Web SMS extension consists of the letter 's' followed by a number (e.g. 's0'). The sipgate API uses the concept of Web SMS extensions to identify devices within your account that are enabled to send SMS. In this context the term 'device' does not necessarily refer to a hardware phone but rather a virtual connection.

You can use the sipgate api to find out what your extension is. For example:

```bash
curl \
--user tokenId:token \
https://api.sipgate.com/v2/{userId}/sms
```

Replace `tokenId` and `token` with your sipgate credentials and `userId` with your sipgate user id.

The user id consists of the letter 'w' followed by a number (e.g. 'w0'). It can be found as follows:

1. Log into your [sipgate account](https://app.sipgate.com)
2. The URL of the page should have the form `https://app.sipgate.com/{userId}/...` where `{userId}` is your user id.

### Common Issues

#### SMS sent successfully but no message received

Possible reasons are:

- incorrect or mistyped phone number
- recipient phone is not connected to network
- long message text - delivery can take a little longer

#### HTTP Errors

| reason                                                                                                                                              | errorcode |
| --------------------------------------------------------------------------------------------------------------------------------------------------- | :-------: |
| bad request (e.g. request body fields are empty or only contain spaces, timestamp is invalid etc.)                                                  |    400    |
| tokenId and/or token are wrong                                                                                                                      |    401    |
| insufficient account balance                                                                                                                        |    402    |
| no permission to use specified SMS extension (e.g. SMS feature not booked, user password must be reset in [web app](https://app.sipgate.com/login)) |    403    |
| wrong REST API endpoint                                                                                                                             |    404    |
| wrong request method                                                                                                                                |    405    |
| wrong or missing `Content-Type` header with `application/json`                                                                                      |    415    |
| internal server error or unhandled bad request (e.g. `smsId` not set)                                                                               |    500    |

### Related

- [sipgate team FAQ (DE)](https://teamhelp.sipgate.de/hc/de)
- [sipgate basic FAQ (DE)](https://basicsupport.sipgate.de/hc/de)

### Contact Us

Please let us know how we can improve this example.
If you have a specific feature request or found a bug, please use **Issues** or fork this repository and send a **pull request** with your improvements.

### License

This project is licensed under **The Unlicense** (see [LICENSE file](./LICENSE)).

### External Libraries

This code uses the following external libraries

- Zttp:
  - Licensed under the [MIT License](https://opensource.org/licenses/MIT)
  - Website: [https://github.com/kitetail/zttp](https://github.com/kitetail/zttp)

---

[sipgate.io](https://www.sipgate.io) | [@sipgateio](https://twitter.com/sipgateio) | [API-doc](https://api.sipgate.com/v2/doc)
