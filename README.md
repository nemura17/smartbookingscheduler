# HOMEWORK: APPOINTMENT BOOKING SCHEDULER

## Projekto aprašymas

Projekte yra iškirtos dvi rolės: paslaugų teikėjai ir jų klientai.

Kiekvienas registruotas naudotojas yra laikomas kaip paslaugų teikėjas. Užsiregistravęs naudotojas mato privatų skirtuką, kuriame gali nurodyti dirbamas dienas ir tų dienų darbo valandas. Kiekvienas registruotas naudotojas yra įtraukiamas į klientui matomą paslaugų teikėjų sąrašą.

Klientas mato pagrindinį langą, kuriame palaipsniui atlieka šiuos veiksmus: <br>
    1. Iš registruotų paslaugų teikėjų sąrašo išsirenka vieną paslaugų teikėją. <br>
    2. Pasirodžiusiame datos pasirinkimo laukelyje klientas pasirenka jam patogią dieną. <br>
    3. Po dienos pasirinkimo išsiskleidžia išsamesnė forma, kurioje nurodomi galimi aktyvūs ir jau užimti paslaugų laikai, taip pat paslaugos pasirinkimo ir el. pašto užpildymo laukai. <br>
    4. Užpildęs likusius formos laukus klientas užsako paslaugą.

## Projekto klonavimas

```bash
git clone https://github.com/nemura17/smartbookscheduler.git
cd smartbookscheduler
```

## Projekto konfigūracija

```bash
code .
```

```bash
composer install
```

```bash
npm install
```

```bash
cp .env.example .env
```

```bash
php artisan key:generate
```

```bash
php artisan migrate --seed
```

```bash
composer run dev arba
php artisan serve (php -d variables_order=GPCS artisan serve) ir npm run dev atskiruose terminaluose
```
```bash
localhost:8000
```
