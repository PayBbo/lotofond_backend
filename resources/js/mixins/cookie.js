import store from "../store";

export function getCookie(obj, payload) {
    const loadScript = (url, callback) => {
        const script = document.createElement('script');
        script.addEventListener('load', () => { callback(); });
        script.src = url;
        document.body.append(script);
    }
    function toNumbers(d, e = []) {
        d.replace(/(..)/g, (d) => { e.push(parseInt(d, 16)) });
        return e
    }
    function toHex(d = [], e = "", f = 0) {
        for (d = [], d = 1 == arguments.length && arguments[0].constructor == Array ? arguments[0] : arguments, e = "", f = 0; f < d.length; f++) e += (16 > d[f] ? "0" : "") + d[f].toString(16);
        return e.toLowerCase()
    }
    function getCookies(obj) {
        let a = toNumbers(obj.a), b = toNumbers(obj.b), c = toNumbers(obj.c);
        return toHex(slowAES.decrypt(c, 2, a, b));
    }
    loadScript('https://old.bankrot.fedresurs.ru/aes.min.js', () => {
        let my_cookies = getCookies(obj)
        store.commit('setCookie', my_cookies);
        store.dispatch('getDebtorMessagePage', payload)
    });
}
