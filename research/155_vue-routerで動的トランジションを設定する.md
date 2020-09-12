### ※※※「やろうとしたこと」で解決していた。別のところで設定ミス

### やりたいこと
- ページに応じた遷移時のトランジションを設定する
- 設定をvue-routerに集約したい
  - ページ遷移前に遷移用のパラメタをstoreへ設定する
  - `transition`は算出プロパティを参照する

### やろうとしたこと
- `beforeEnter`でnext()の前に差し込む
  - stateが更新される前にnext()が動く(?)ので、これでは不可
```js
        beforeEnter(to, from, next) {
            if (store.getters["auth/check"]) {
                store.commit("mode/setTransitionType", TRANSITION_TYPE.PAGE_IN);
                next();
            } else {
                // 未ログインの場合はログインページへリダイレクト
                store.commit(
                    "mode/setTransitionType",
                    TRANSITION_TYPE.FADE_FASTER
                );
                next({ name: "signin" });
            }
        }
```
### 対応
- actionからPromiseを返して同期させる
```js
const actions = {
    /**
     * トランジションの種類を設定します。
     * NOTE: vue-routerから非同期に実行するため、Promiseを返す必要がある
     *       mutationsはPromiseを返せないようなのでactionsに定義してdispatchする。
     */
    async setTransitionType(context, val) {
        console.log("セットするよ～！！！");
        await context.commit("setTransitionType", val);
        return false;
    }
};
```
```js
        async beforeEnter(to, from, next) {
            if (store.getters["auth/check"]) {
                await store.dispatch("mode/setTransitionType", TRANSITION_TYPE.FADE);
                console.log("セットしたよ～！！！");
                next();
            } else {
                // 未ログインの場合はログインページへリダイレクト
                await store.dispatch(
                    "mode/setTransitionType",
                    TRANSITION_TYPE.FADE_FASTER
                );
                next({ name: "signin" });
            }
        }
```

#### 参考
https://www.it-swarm.dev/ja/javascript/beforeenter%E3%83%95%E3%83%83%E3%82%AF%E3%81%A7%E4%BD%BF%E7%94%A8%E3%81%99%E3%82%8B%E3%81%9F%E3%82%81%E3%81%ABvuerouter%E3%81%AE%E9%9D%9E%E5%90%8C%E6%9C%9F%E3%82%B9%E3%83%88%E3%82%A2%E3%83%87%E3%83%BC%E3%82%BF%E3%81%AB%E3%82%A2%E3%82%AF%E3%82%BB%E3%82%B9%E3%81%99%E3%82%8B%E6%96%B9%E6%B3%95%E3%81%AF%EF%BC%9F/829780893/
```js
{
  path: '/example',
  component: Example,
  beforeEnter: (to, from, next) =>
  {
    store.dispatch('initApp').then(response => {
        // the above state is not available here, since it
        // it is resolved asynchronously in the store action
    }, error => {
        // handle error here
    })         
  }
}
```

