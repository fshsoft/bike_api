# 接口

接口返回的结果中，必存在errno,errmsg两个字段，如果有数据返回，那么数据放在data字段中

## /oauth2/access_token

* 请求方式：POST

* 请求参数：
 
 - grant_type *
 - client_id *
 - client_secret *
 - scope *
 - username 
 > 只有grant_type为password时候才有用
 - password 
 > 只有grant_type为password时候才有用
 - refresh_token
 > 只有grant_type为refresh_token时候才有用


* 返回结果：

 - token_type *
 - expires_in *
 - access_token *
 - refresh_token
 > 只有grant_type为password和refresh_token的时候才有


## /v1/sms/send_login_code

发送短信登入验证码

* 请求方式：GET

* 请求参数：
 
 - mobi *
 
* 返回结果：

 - errno *
 > 0 1 2
 - errmsg *

## /v1/users/current

取得当前登入用户信息

 * 请求方式: GET

 * 请求参数:

 * 返回结果

  - errno *
  > 0 1 2 4
  - errmsg *
  - data *
    - user *
    > User

## /v1/bikes

取得可用车辆
 
 * 请求方式: GET

 * 请求参数:

  - lat *
  - lng *
  - range *
  > 单位千米，可精确到小数点后1位

 * 返回结果

  - errno *
  > 0 1 2
  - errmsg *
  - data *
    - list *
    > Bike[]

## /v1/bikes/{id}/use

使用指定车辆

 * 请求方式: POST

 * 请求参数: 

  - lat *
  > 用户所在纬度
  - lng *
  > 用户所在经度

 * 返回结果

  - errno *
  > 0 1 2 4 5
  - errmsg *

## /v1/bikes/{id}/checkout

获取结账信息

 * 请求方式: GET

 * 请求参数:

 * 返回结果

  - errno *
  > 0 1 2 4
  - errmsg *
  - data
    - dura 
    > 骑行时间, 单位秒
    - amou
    > 金额

## /v1/bikes/{id}/checkout

 结账

 * 请求方式: PUT

 * 请求参数:

 * 返回结果

  - errno *
  > 0 1 2 4 5
  - errmsg *

# 对象

## User
 - id *
 - mobi *
 - name *
 - avt *
 > avatar 头像
 - idno *
 > 身份证号
 - certif *
 > 是否实名认证
 - bal *
 > 账户余额
 - llip *
 > 上次登入ip
 - llt *
 > 上次登入时间戳
 - regt *
 > 注册时间戳

## Bike
 - id *
 - lat *
 - lng *

# 错误代码

 - 0 成功
 - 1 错误
 - 2 access token不合法
 - 3 refresh token 不合法
 - 4 用户未找到
 - 5 余额不足
