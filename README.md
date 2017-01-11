# mail_sender
A php tool for send email , can be used for curl or any other http tools


## BASIC SUPPORT
RUN ENV : 

1. apache + php  or nginx + php 
2. linux server with sendmail service or postfix service (you can use yum install postfix to install the dependency if you are using an centos server like me )

#### INTERFACE
##### /sender.php
Description:  
This interface is used for send mail , all receivers can receive the mail。

Arguments:

|argu name    |method  |required  |description | 
|:-----------:|:------:|:--------:|:----------:|
|receiver     |post/get|true      |string(split by comma)|
|from         |post/get|false     |string(mail sender, mail_service@noreply.com is the default value)|
|subject      |post/get|true      |string| 
|text         |post    |false     |string(content of the mail)|
|content      |post    |false     |file(or you can use the to upload the content)|
|attachment   |post    |false     |file|


## ADVANCE SUPPORT(MAIL GROUP)
RUN ENV:  

1. apache + php  or nginx + php 
2. linux server with sendmail service or postfix service (you can use yum install postfix to install the dependency if you are using an centos server like me )
3. mysql (should set settings.php & init_db.sh correctly and then init mysql by using the init_db.sh script )

#### INTERFACE
##### /sender.php
Description:  
This interface is used for send mail , all receivers can receive the mail.

Arguments:

|argu name    |method  |required  |description |
|:-----------:|:------:|:--------:|:----------:|
|receiver     |post/get|true      |string(can include mail group name;split by comma)|
|from         |post/get|false     |string(mail sender, mail_service@noreply.com is the default value)|
|subject      |post/get|true      |string| 
|text         |post    |false     |string(content of the mail)|
|content      |post    |false     |file(or you can use the to upload the content)|
|attachment   |post    |false     |file|

##### /front.php
Description:  
Web service of mail group.

Arguments
none

##### /group_info_operator.php
Description:  
Add or delete a mail group,group owner will be the first member of the group.If you are deleting a mail group ,remeber all the members of the group will also be deleted.

Arguments:

|argu name    |method  |required  |description | 
|:-----------:|:------:|:--------:|:----------:|
|type         |post/get|true      |string(add or delete)|
|group_name   |post/get|true      |string(this name cannot repeat in global)|
|group_owner  |post/get|true      |string(mail addr of owner, will be the first member of the mail group)|

##### /group_member_operator.php
Description:  
Add or delete a mail group member.

Arguments:

|argu name    |method  |required  |description | 
|:-----------:|:------:|:--------:|:----------:|
|type         |post/get|true      |string(add or delete)|
|group_name   |post/get|true      |string|
|group_member |post/get|true      |string(mail addr of group member)|

##### /query_group_list.php
Description:  
Get mail group list.

Arguments:
none

##### /query_group_member.php
Description:  
Get mail group member list of a group.

Arguments:

argu name    |method  |required  |description 
|:-----------:|:------:|:--------:|:----------:|
|group_name   |post/get|true      |string|


bryanzhou  
2017.01.01
