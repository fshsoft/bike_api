

# 接口

## /oauth2/access_token

* 请求方式：POST

* 请求参数：
 
 - grant_type 
 - client_id
 - client_secret
 - scope
 - username 
 > 只有grant_type为password时候才有用
 - password 
 > 只有grant_type为password时候才有用
 - refresh_token
 > 只有grant_type为refresh_token时候才有用


* 返回结果：

 - token_type
 - expires_in
 - access_token
 - refresh_token
 > 只有grant_type为password和refresh_token的时候才有


## /v1/sms/send_login_code

* 请求方式：GET

* 请求参数：
 
 - mobile
 
* 返回结果：

 - errno
 - errmsg
 - data
   - code
   > 手机验证码


# 对象

## User

```json
{
    "id": 1,
    "mobile": "13862026360"
}
```

## Bike

```json
{
    "id": 123456,
    "elock_id": 34567
}
```

# 错误代码

 - 1 通用错误
 - 2 Access_Token不合法

