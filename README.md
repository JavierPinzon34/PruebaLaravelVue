# Test developer full stack [Cidenet](https://www.cidenet.com.co/)
## Tech
- [Laravel v7.x](https://laravel.com/docs/7.x)
- [Vuejs](https://vuejs.org/v2/guide/)
- [Axios](https://www.npmjs.com/package/axios)
- [Bootstrap v4.6](https://getbootstrap.com/docs/4.6/getting-started/introduction/)
- [Font Awesome v4.7](https://fontawesome.com/v4.7/)
- [Vue-SweetAlert2](https://www.npmjs.com/package/vue-sweetalert2)
- [Vue-Laravel-Pagination](https://github.com/gilbitron/laravel-vue-pagination)
- [Php ^7.3](https://www.php.net/)
## Installation
```sh
git clone https://gitlab.com/JavierPinzon34/pruebacidenet.git
cd pruebacidenet/
cp .env.example .env (config conection DB)
composer install
php artisan key:generate
php artisan migrate --seed
npm install
npm run build
php artisan serve
http://127.0.0.1:8000
```
## Login
**E-mail:** jspinzonr@misena.edu.co
**Password:** 123456789
