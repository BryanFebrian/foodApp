# Menggunakan image PHP dengan Apache
FROM php:7.4-apache

# Install ekstensi yang diperlukan untuk MySQL
RUN docker-php-ext-install mysqli

# Salin semua file proyek ke folder kerja di Docker
COPY . /var/www/html/

# Beri izin pada folder upload (jika diperlukan)
RUN chmod -R 755 /var/www/html/uploaded_img
