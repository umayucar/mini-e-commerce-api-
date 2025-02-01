# Laravel Mini E-Ticaret API Geliştirme

## Proje Kurulumu

Bu proje, Laravel framework'ü kullanılarak geliştirilmiş bir mini e-ticaret API'sidir.

### Gereksinimler

- PHP 8.1+
- Composer
- Laravel 10+
- MySQL veya PostgreSQL

### Kurulum Adımları

1. Projeyi klonlayın:
   ```bash
   git clone https://github.com/umayucar/mini-e-ticaret-api-.git
   cd mini-e-ticaret-api-
   ```

2. Bağımlılıkları yükleyin:
   ```bash
   composer install
   ```

3. Ortam dosyasını oluşturun:
   ```bash
   cp .env.example .env
   ```

4. .env dosyasını düzenleyerek veritabanı bağlantı bilgilerini girin:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=mini-e-commerce-api
   DB_USERNAME=root
   DB_PASSWORD=
   ```

5. Veritabanını oluşturun:
   ```bash
   php artisan migrate --seed
   ```

6. Sunucuyu başlatın:
   ```bash
   php artisan serve
   ```

## Repository ve Service Yapısı

### Repository Pattern

Repository deseni, veritabanı sorgularını kontrol katmanından ayırır.

- **ProductRepository**: `Product` tablosuyla ilgili veritabanı işlemlerini barındırır.
- **CartRepository**: `Cart` ve `CartItem` tablosuyla ilgili işlemleri barındırır.

### Service Layer Pattern

Service katmanı, iş mantığını kontrol katmanından ayırır.

- **CartService**: Sepet işlemlerini barındırır.
  - Sepete ürün ekleme
  - Sepet toplam tutarı hesaplama

### Dependency Injection

Laravel’in Service Container'ı kullanılarak repository ve service sınıfları controller'a enjeksiyon yoluyla aktarılmıştır.

## API Endpoint Kullanımları

### 1. Tüm ürünleri listeleme

**Endpoint:** `GET /products`

**Cevap:**
```json
[
    {
        "id": 1,
        "name": "Linen Fleece Hoodie",
        "price": "230.92",
        "created_at": "2025-02-01T07:34:25.000000Z",
        "updated_at": "2025-02-01T07:34:25.000000Z"
    },
    {
        "id": 2,
        "name": "Teal Cotton T-Shirt",
        "price": "833.21",
        "created_at": "2025-02-01T07:34:25.000000Z",
        "updated_at": "2025-02-01T07:34:25.000000Z"
    },
]
```

### 2. Yeni bir sepet oluşturma

**Endpoint:** `POST /cart`

**Gövde:**
```json
{
    "user_id": 1
}
```

**Cevap:**
```json
{
    "message": "Yeni sepet oluşturuldu!",
    "data": {
        "user_id": 1,
        "updated_at": "2025-02-01T08:02:26.000000Z",
        "created_at": "2025-02-01T08:02:26.000000Z",
        "id": 3
    }
}
```

### 3. Sepete ürün ekleme

**Endpoint:** `POST /cart/{cart_id}/items`

**Gövde:**
```json
{
    "product_id": 2,
    "quantity": 3
}
```

**Cevap:**
```json
{
    "message": "Ürün sepete eklendi!",
    "data": {
        "product_id": 2,
        "quantity": 3,
        "cart_id": 1,
        "updated_at": "2025-02-01T08:01:59.000000Z",
        "created_at": "2025-02-01T08:01:59.000000Z",
        "id": 4
    }
}
```

### 4. Sepet toplam tutarı hesaplama

**Endpoint:** `GET /cart/{cart_id}/total`

**Cevap:**
```json
{
    "message": "Sepet toplamı hesaplandı!",
    "total": 1621.34
}
```

## Tasarım Desenleri

### Repository Pattern
Repository deseni, veritabanı işlemlerini soyutlayarak controller'ların sadece servisler aracılığıyla veri alıp göndermesini sağlar. Bu projede, `ProductRepository` ve `CartRepository` sınıflarıyla bu yapı oluşturulmuştur.

### Service Layer Pattern
Service katmanı, iş mantığını controller'dan ayırmak için kullanılmıştır. `CartService` sınıfı sepete ürün ekleme ve toplam tutar hesaplama gibi işlemleri barındırır.

### Dependency Injection
Laravel’in Service Container yapısı kullanılarak repository ve service sınıfları, controller'lara enjeksiyon yoluyla aktarılmıştır. Bu sayede bağımlıklar daha esnek hale getirilmiştir.

## Testler

### Unit Testler
- Repository ve Service sınıflarının test edilmesi için PHPUnit kullanılmıştır.
- Sepet toplamının doğru hesaplanması test edilmiştir.

### Feature Testler
- API endpoint'lerinin doğru çalışıp çalışmadığı test edilmiştir.

## Event & Listener Kullanımı 
- **CartTotalCalculated** event’i, sepet toplamı hesaplandığında tetiklenmektedir.
- **CartTotalLoggerListener** sınıfı, bu eventi loglamak için kullanılmaktadır.
 

### Postman API Dokümanı 
Postman üzerinden API'yi test etmek için aşağıdaki dokümana göz atabilirsiniz:
[Postman API Dokümanı](https://documenter.getpostman.com/view/27989363/2sAYX3q36i#47f02d47-48a3-480f-b1d9-1a614190188b)
