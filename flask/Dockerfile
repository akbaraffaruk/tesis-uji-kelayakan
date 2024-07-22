# Gunakan image dasar Python
FROM python:3.9-slim

# Set working directory
WORKDIR /app

# Salin file requirements.txt dan instal dependensi
COPY requirements.txt requirements.txt
RUN pip install --no-cache-dir -r requirements.txt

# Salin semua file ke working directory
COPY . .

# Tentukan port Flask
EXPOSE 5000

# Perintah untuk menjalankan aplikasi Flask
CMD ["python", "app.py"]
