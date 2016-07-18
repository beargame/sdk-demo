var BEAR = {
	goToPay: function(a, b, c,d,e) {
        var data = {action:'pay_redirect',appId:a,productId:b,gameUid:c,gameUserName:d,extra:e}
        window.parent.postMessage(data,'*');
    },
    isPc:function() {
        if (BEAR.isAndroid()==false && BEAR.isiOS()==false && BEAR.isWeixin()==false) {
            return false
        } else {
            return false
        }
    },
    isAndroid: function() {
        return navigator.userAgent.indexOf("Android") > -1 || navigator.userAgent.indexOf("Linux") > -1
    },
    isiOS: function() {
        return !!navigator.userAgent.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/)
    },
    isWeixin: function() {
        return "micromessenger" == navigator.userAgent.toLowerCase().match(/MicroMessenger/i)
    },
    getURLVar: function(a) {
        var b = new RegExp("(^|&)" + a + "=([^&]*)(&|$)", "i"),
            c = window.location.search.substr(1).match(b);
        return null != c ? unescape(c[2]) : null
    },
    shareTimeline:function(title,link,imgUrl) {
    	parent.shareTimeline(title,link,imgUrl)
    },
    shareFriend:function(title,desc,link,imgUrl) {
    	parent.shareFriend(title,desc,link,imgUrl)
    },
    shareQQ:function(title,desc,link,imgUrl) {
    	parent.shareQQ(title,desc,link,imgUrl)
    },
    shareQzone:function(title,desc,link,imgUrl) {
    	parent.shareQzone(title,desc,link,imgUrl)
    }
}