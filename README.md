# HOMEWORK: APPOINTMENT BOOKING SCHEDULER

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

## Projekto aprašymas

Projekte yra iškirtos dvi rolės: paslaugų teikėjai ir jų klientai.

Kiekvienas registruotas naudotojas yra laikomas kaip paslaugų teikėjas. Užsiregistravęs naudotojas mato privatų skirtuką, kuriame gali nurodyti dirbamas dienas ir tų dienų darbo valandas.

Klientas mato pagrindinį langą, kuriame palaipsniui atlieka šiuos veiksmus:
    1. Iš registruotų paslaugų teikėjų sąrašo išsirenka vieną paslaugų teikėją.
    2. Pasirodžiusiame datos pasirinkimo laukelyje klientas pasirenka jam patogią dieną.
    3. Po dienos pasirinkimo išsiskleidžia išsamesnė forma, kurioje nurodomi galimi aktyvūs ir jau užimti paslaugų laikai, taip pat paslaugos pasirinkimo ir el. pašto užpildymo laukai.
    4. Užpildęs likusius formos laukus klientas užsako paslaugą.
