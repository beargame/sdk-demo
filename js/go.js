var GO = {
    _pre: "by_",
    name: null,
    city: null,
    province: null,
    face: null,
    token: null,
    init: function() {
        var token = this.getURLVar("token")
        if (token != null && token.length > 10) {
            $.post("api.php?c=user&a=getUserInfo&token=" + token, function(data) {
                if (data.code == 0) {
                    GO.token = token
                    GO.name = data.res.name
                    GO.city = data.res.city
                    GO.province = data.res.province
                    GO.face = data.res.face
                    GO.set("token", GO.token)
                    GO.set("name", GO.name)
                    GO.set("city", GO.city)
                    GO.set("province", GO.province)
                    GO.set("face", GO.face)
                } else {
                    GO.weixinLogin();
                }
            }, "json")
        } else {
            GO.weixinLogin();
        }
    },
    refresh: function() {

        if (this.token == null) {
            this.token = this.get("token")
            this.name = this.get("name")
            this.city = this.get("city")
            this.province = this.get("province")
            this.face = this.get("face")
        }
    },
    set: function(a, b) {
        if (window.localStorage) {
            window.localStorage.setItem(this._pre + a, b);
        } else {
            var c = new Date;
            c.setTime(c.getTime() + 31536e6), document.cookie = this._pre + a + "=" + escape(b) + ";expires=" + c.toGMTString()
        }
    },
    get: function(a) {
        if (window.localStorage) {
            return window.localStorage.getItem(this._pre + a);
        } else {
            var b = document.cookie.match(new RegExp("(^| )" + this._pre + a + "=([^;]*)(;|$)"));
            return null != b ? unescape(b[2]) : null
        }
    },
    remove: function(a) {
        if (window.localStorage) {
            window.localStorage.removeItem(this._pre + a)
        } else {
            var b, c;
            b = new Date
            b.setTime(b.getTime() - 1)
            c = this.get(a)
            if (null != c) {
                document.cookie = this._pre + a + "=" + c + ";expires=" + b.toGMTString()
            }
        }
    },
    goToPay: function(a, b, c) {
        var url = "http://g.ibingyi.com/shop.php?appId=" + a + "&productId=" + b + "&extra=" + c;
        top.location.href = url
    },
    getURLVar: function(a) {
        var b = new RegExp("(^|&)" + a + "=([^&]*)(&|$)", "i"),
            c = window.location.search.substr(1).match(b);
        return null != c ? unescape(c[2]) : null
    },
    wxAppId: 'wxc03adecc28213ae1',
    loginUrl: 'http://g.ibingyi.com/api.php?c=plat&a=login',
    weixinUrl: function() {
        return 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=' + this.wxAppId + '&redirect_uri=' + encodeURIComponent(this.loginUrl) + '&response_type=code&scope=snsapi_userinfo&state=weixin#wechat_redirect'
    },
    weixinLogin: function() {
        location.href = this.weixinUrl()
    }
}