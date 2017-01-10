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

1. receiver      post/get     string(split by comma)
2. from          post/get     string(mail sender, mail_service@noreply.com is the default value)
3. subject       post/get     string 
4. text          post         string(content of the mail)
5. content       post         file(or you can use the to upload the content)
6. attachment    post         file


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

1. receiver      post/get     string(can include mail group name;split by comma)
2. from          post/get     string(mail sender, mail_service@noreply.com is the default value)
3. subject       post/get     string 
4. text          post         string(content of the mail)
5. content       post         file(or you can use the to upload the content)
6. attachment    post         file

##### /front.php
Description:  
Web service of mail group.

Arguments
none

##### /group_info_operator.php
Description:  
Add or delete a mail group,group owner will be the first member of the group.If you are deleting a mail group ,remeber all the members of the group will also be deleted.

Arguments:

1. type          post/get     string(add or delete)
2. group_name    post/get     string(this name cannot repeat in global)
3. group_owner   post/get     string(mail addr of owner, will be the first member of the mail group)

##### /group_member_operator.php
Description:  
Add or delete a mail group member.

Arguments:

1. type          post/get     string(add or delete)
2. group_name    post/get     string
3. group_member  post/get     string(mail addr of group member)

##### /query_group_list.php
Description:  
Get mail group list.

Arguments:
none

##### /query_group_member.php
Description:  
Get mail group member list of a group.

Arguments:

1. group_name    post/get     string


bryanzhou  
2017.01.01
