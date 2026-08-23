#!/bin/sh
# Jalanin ini di server tiap abis update kode Sitaku
set -e

echo ">> git pull"
git pull

echo ">> build image app (exavro-app:latest)"
docker compose build exavro

echo ">> recreate semua container biar pake image baru"
docker compose up -d --force-recreate exavro queue reverb webexavro

echo ">> selesai. cek log kalau perlu:"
echo "   docker compose logs -f exavro"
echo "   docker compose logs -f queue"
echo "   docker compose logs -f reverb"