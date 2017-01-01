# mail_sender
A php tool for send email , can be used for curl or any other http tools

RUN ENV : 

1. apache + php  or nginx + php 
2. linux server with sendmail service or postfix service (you can use yum install postfix to install the dependency if you are user a centos server like me )

USAGE:

1. receiver      post/get     string
2. subject       post/get     string 
3. text          post         string(content of the mail)
4. content       post         file(or you can use the to upload the content)
5. attachment    post         file


bryanzhou

2017.01.01
