[![Build Status](https://camo.githubusercontent.com/f5054ffcd4245c10d3ec85ef059e07aacf787b560f83ad4aec2236364437d097/68747470733a2f2f696d672e736869656c64732e696f2f62616467652f636f6e747269627574696f6e732d77656c636f6d652d627269676874677265656e2e7376673f7374796c653d666c6174)]()
## Fingerspot Library

***Fingerspot Libray** digunakan untuk mengambil data absensi dari mesin fingerspot dengan perantara EasylinkSDK.* menggunakan CodeIgniter 3

### Features

1. Get Users
2. Delete User / All User
3. Get All Data Attendance
4. Get Newest Data Attendance
5. Delete All Data Attendance
6. Get Machine Information
7. Sync Datetime on Fingerspot
8. Delete Data User Admin
9. Clear all data
### Installation

### Setting env
```shell
FP_SERVER_HOST=
FP_SERVER_PORT=
FP_SERIAL_NUMBER=
```

### Load library
```php
$this->load->library('fingerprint');
```
