<head>
    <script type="text/javascript">
        function loadXMLDoc(name) {
            var xmlhttp;
            if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp = new XMLHttpRequest();
            }
            else {// code for IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function () {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    document.getElementById("myDiv").innerHTML = xmlhttp.responseText;
                }
            }
            xmlhttp.open("GET", "query_group_member.php?group_name=" + name, true);
            xmlhttp.send();
        }
    </script>
</head>
<body>
<button type="button" onclick="loadXMLDoc('weibo_im_qa')">请求数据</button>

<div id="myDiv"></div>

</body>