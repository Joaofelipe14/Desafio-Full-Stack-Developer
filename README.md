
# Desafio Full-Stack Developer - Product Team

Aplicação Full-Stack para gestão de clientes integrando Huggy (webhook e login), VoIP com Twilio, envio de e-mail agendado e relatórios com gráficos.

---

## ✅ Funcionalidades Básicas

| Funcionalidade                                             | Status          |
|------------------------------------------------------------|-----------------|
| CRUD de clientes                                           | Implementado ✅ |
| Armazenamento com MySQL                                   | Implementado ✅ |
| Webhook da Huggy para captura de dados                    | Implementado ✅ |
| Envio de e-mail de boas-vindas (job + delay de 30 min)    | Implementado ✅ |
| Integração com Twilio para ligações VoIP                  | Implementado ✅ |
| Relatórios com gráficos (cidade, idade, etc.)             | Implementado ✅ |
| Autenticação segura                                        | Implementado ✅ |
| Validação de dados (frontend/backend)                     | Implementado ✅ |
| Busca, cadastro, edição e exclusão de clientes (UI)       | Implementado ✅ |
| Botão de ligação para clientes com telefone               | Implementado ✅ |
| Visualização de gráficos na interface                     | Implementado ✅ |

---

## 🚀 Funcionalidades Extras

| Funcionalidade Extra                         | Descrição                                 |
|---------------------------------------------|-------------------------------------------|
| Paginação de clientes                       | Implementada na API e no frontend         |
| Integração com login da Huggy               | Autenticação usando API Huggy             |
| Gráficos por faixa etária                   | Utilizando ApexCharts                     |
| Componentização com Vue 3                   | UI 100% modular com componentes           |
| Confirmação visual de exclusão              | Modal com alerta antes de excluir cliente |

---

## ▶️ Como rodar o projeto

### Backend (Laravel)

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan serve
php artisan queue:work --tries=3 --delay=10 --sleep=3 --verbose
```
Obs: Certifique-se configurar as variaveis de ambiente corretamente

### Frontend (Vue)

```bash
cd frontend
npm install
npm run dev
```

---

## 📮 Documentação da API

[📫 Acessar Collection no Postman](COLE_AQUI_A_URL_DA_COLLECTION)

---

## 🗂 Estrutura de Pastas

### 📦 Backend (Laravel)

## 🗂 Estrutura de Pastas

### 📦 Backend (Laravel)

| Pasta/Arquivo                   | Descrição                                                  |
|--------------------------------|------------------------------------------------------------|
| `app/Http/Controllers`         | Controladores responsáveis pelas rotas e lógica da API     |
| `app/Jobs`                     | Jobs assíncronos (envio de e-mail, envio de webhook)       |
| `app/Mail`                     | Templates e definição dos e-mails enviados                 |
| `app/Models`                   | Modelos das entidades (Client, User, City, State, etc.)    |
| `routes/api.php`               | Definição das rotas da API                                 |
| `database/migrations`          | Arquivos de migração de tabelas no banco de dados          |
| `database/seeders`             | Popular o banco com dados iniciais                         |



---

### 🖥️ Frontend (Vue 3 + Vite + TypeScript)

| Pasta/Arquivo             | Descrição                                                        |
|--------------------------|------------------------------------------------------------------|
| `src/components`          | Componentes reutilizáveis (form, modais, gráficos, botões, etc.) |
| `src/pages`               | Páginas principais da aplicação (Login, Clientes, Relatórios)    |
| `src/router`              | Arquivo de rotas da aplicação                                   |
| `src/services`            | Comunicação com backend, com a api                       |
| `src/types`               | Definições de tipos TypeScript utilizados na aplicação          |


---

