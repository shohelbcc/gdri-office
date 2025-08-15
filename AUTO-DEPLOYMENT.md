# 🚀 GDRI Auto Deployment Setup Guide

## 📋 Overview
এই setup এর মাধ্যমে আপনি local থেকে `git push` করলেই automatically আপনার server এ deploy হবে।

## 🔧 GitHub Secrets Setup

GitHub repository তে যান এবং **Settings > Secrets and Variables > Actions** এ গিয়ে এই secrets add করুন:

### Required Secrets:

```
GDRI_OFFICE_FTP_HOST=ftp.mshohel.com
GDRI_OFFICE_FTP_USERNAME=gdri_office@office.mshohel.com  
GDRI_OFFICE_FTP_PASSWORD=7901_gdri_office
```

### Optional Secrets (SSH access থাকলে):

```
SSH_HOST=office.mshohel.com
SSH_USERNAME=mshohel
SSH_PASSWORD=your_ssh_password
SSH_PORT=22
```

## 📁 Server Setup

### 1. Database তৈরি করুন:
- cPanel > MySQL Databases থেকে database তৈরি করুন
- Database name: `mshohel_gdri`
- User তৈরি করে database এর সাথে connect করুন

### 2. .env File Setup:
First deployment এর পর server এ `.env` file check করুন এবং database credentials update করুন।

## 🚀 How It Works

### Automatic Deployment Flow:

1. **আপনি local এ code change করেন**
2. **Git commit & push করেন:**
   ```bash
   git add .
   git commit -m "Your changes"
   git push origin master
   ```

3. **GitHub Actions automatically:**
   - Code checkout করে
   - PHP dependencies install করে
   - Frontend assets build করে
   - FTP দিয়ে server এ upload করে
   - Laravel optimization করে (যদি SSH available থাকে)

4. **আপনার website automatically update হয়ে যায়! 🎉**

## 📊 Deployment Status

GitHub repository তে **Actions** tab এ গিয়ে deployment status দেখতে পারবেন:
- ✅ Success: Deployment completed
- ❌ Failed: Check logs for issues
- 🟡 Running: Deployment in progress

## 🔍 Monitoring & Logs

### GitHub Actions Logs:
- Repository > Actions tab এ click করুন
- Latest workflow run দেখুন
- Detailed logs এবং error messages পাবেন

### Server Logs:
- Check `/home/mshohel/office.mshohel.com/storage/logs/laravel.log`
- Check `deployment.log` for deployment history

## 🛡️ Security Best Practices

1. **Secrets Protection:**
   - GitHub secrets এ sensitive data store করুন
   - `.env` file server এ manually setup করুন

2. **File Permissions:**
   - Script automatically permissions set করে
   - Manual check: `chmod -R 755 storage/`

3. **Database Security:**
   - Strong passwords use করুন
   - Database user এ শুধু necessary permissions দিন

## 🆘 Troubleshooting

### Common Issues:

#### 1. FTP Connection Failed
- Check FTP credentials in GitHub secrets
- Verify FTP server address and port

#### 2. Database Connection Error
- Update `.env` file on server with correct DB credentials
- Check if database exists and user has permissions

#### 3. File Permissions Error
- SSH access থাকলে: `chmod -R 755 storage/ bootstrap/cache/`
- cPanel File Manager থেকেও permissions change করতে পারেন

#### 4. Asset Loading Issues
- Check if `npm run build` completed successfully
- Verify `public/build` folder exists on server

## 📞 Support

কোন সমস্যা হলে:
1. GitHub Actions logs check করুন
2. Server এর Laravel logs দেখুন
3. Error message সহ screenshot নিন

## 🎯 Next Steps

1. GitHub secrets setup করুন
2. Server এ database তৈরি করুন  
3. First manual deployment করুন
4. `.env` file verify করুন
5. Test একটা small change push করুন

**✨ Setup complete হলে শুধু `git push` করলেই automatic deployment হবে!**
