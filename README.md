# AVTOZAPCHAST ERP + POS TIZIMI

Avtomobil ehtiyot qismlari uchun zamonaviy ERP va POS tizimi.

## Texnologiya Stack

- **Backend:** Laravel 11
- **Database:** MySQL 8
- **Frontend:** Blade Templates
- **Styling:** Tailwind CSS 4
- **Icons:** Font Awesome 6
- **Package Manager:** Composer, NPM

## O'rnatish

### 1. Loyihani klonlash
```bash
git clone https://github.com/murodgot54-cmd/avtozapchast-erp-pos.git
cd avtozapchast-erp-pos
```

### 2. Dependencies o'rnatish
```bash
composer install
npm install
```

### 3. Environment faylini sozlash
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Database sozlamalari
`.env` faylida quyidagilarni o'zgartiring:
```
DB_DATABASE=avtozapchast_erp
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 5. Database migratsiyalarini o'tkazish
```bash
php artisan migrate:fresh --seed
```

### 6. Loyihani ishga tushirish
```bash
php artisan serve
npm run dev
```

Keyin `http://localhost:8000` ga o'ting.

## Modullar

1. **Authentication** - Foydalanuvchi autentifikatsiyasi
2. **Dashboard** - Asosiy statistika
3. **Avtomobillar Katalogi** - Brendlar, modellar
4. **Mahsulotlar** - Inventar boshqaruvi
5. **Ta'minotchilar** - Supplier management
6. **Kirim** - Xarid qilish
7. **Ombor** - Ombor boshqaruvi
8. **POS** - Tezkor sotuv
9. **Mijozlar** - CRM
10. **Nasiya** - Qarz tizimi
11. **Qaytarishlar** - Return management
12. **Xarajatlar** - Xarajat tracking
13. **Valyuta** - Ko'p valyuta
14. **Hisobotlar** - Analytics
15. **Telegram Bot** - Bot integratsiyasi
16. **Sozlamalar** - System settings
17. **Audit Log** - Activity tracking
18. **Backup** - Backup/Restore
19. **API** - REST API
20. **Super Admin** - Multi-branch

## Lisenziya

MIT License

## Muallif

murodgot54-cmd
