
網站 Demo 影片

https://github.com/user-attachments/assets/0343a0d2-e147-4a46-9fcd-bb120a228d54



# 說明

試作的電腦零件購物網站，有使用者的登入、註冊、登出、瀏覽零件商品、購物車功能

有後台管理系統，商品跟商品分類的新增、刪除、編輯、列表

資料庫使用PDO SQlite，用init_db.php會建立三個資料表：商品分類、商品、用戶（包含管理員）

# 使用的程式語言工具

前端：HTML、CSS、JavaScript 後端：php

# 使用方式

確認有裝好php

開啟cmd
cmd輸入指令，移動到專案資料夾
```
cd /d 
```
cmd輸入指令，本地開啟php後端
```
php -S localhost:8000
```
以下網址就能進入自己部屬的php後端網頁

```
http://localhost:8000
```
先到

```
http://localhost:8000/database/init_db.php
```

建立資料表，就能正常使用了


# 專案結構

```
phpDemo/
│
├──index.php                  # 首頁（商品列表）
│
├──phpinfo.php                # 檢查php.ini設定是否正確
│
├──admin/                     # 後台管理資料夾
│  │
│  ├──.env                    # 管理員註冊認證碼寫在裡面
│  │
│  ├──admin_register.php      # 管理員註冊用頁面
│  │
│  ├──categories_add.php      # 商品類別 新增
│  │
│  ├──categories_delete.php   # 商品類別 刪除
│  │
│  ├──categories_edit.php     # 商品類別 編輯
│  │
│  ├──categories_list.php     # 商品類別 列表
│  │
│  ├──parts_add.php           # 商品 新增
│  │
│  ├──parts_delete.php        # 商品 刪除
│  │
│  ├──parts_edit.php          # 商品 編輯
│  │
│  ├──parts_list.php          # 商品 列表
│
├──assets/                    # 資產資料夾
│  │
│  ├──script.js               # 前端javascript
│  │
│  ├──style.css               # 前端css
│
├──cart/                      # 購物車資料夾
│  │
│  ├──add_to_cart.php         # 加入購物車功能
│  │
│  ├──cart.php                # 購物車頁面
│
├──database/                  # 資料庫
│  │
│  ├──db.php                  # 連線資料庫
│  │
│  ├──db.sqlite               # 用cmd啟動init_db.php會建立的資料庫檔案
│  │
│  ├──init_db.php             # PDO SQLite 建立資料庫、資料表
│
├──users/                     # 使用者資料夾
│  │
│  ├──login.php               # 登入
│  │
│  ├──logout.php              # 登出
│  │
│  ├──register.php            # 註冊
```
