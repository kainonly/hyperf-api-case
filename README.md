# Hyperf Api Case

辅助 Hyperf 框架的工具集合使用案例，构建简洁统一的中后台接口方案

- 前端 `https://console.kainonly.com`
  - 用户名 `kain`
  - 密码 `pass@VAN1234`
- 后端 `https://api.kainonly.com`

> 前端对应开源项目 https://github.com/kainonly/ngx-bit

#### 安装

首选需要创建一个 hyperf 官方的骨架项目

```shell script
composer create-project hyperf/hyperf-skeleton
```

然后安装必备的 CURD API 的工具集 `kain/hyperf-curd`

```shell script
composer require kain/hyperf-curd
```

案例中使用 `kain/hyperf-extra` 包含了一些常用的扩展工具

```shell script
composer require kain/hyperf-extra
```

`kain/hyperf-support` 辅助 Hyperf 的特性功能支持库

```shell script
composer require kain/hyperf-support
```
