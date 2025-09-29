PS C:\Users\Administrator\herd\pengantar_desa> php artisan migrate
>>

   INFO  Running migrations.

  2025_09_28_225436_create_notifications_table ................................................................................. 5.04ms FAIL

   Illuminate\Database\QueryException 

  SQLSTATE[42S01]: Base table or view already exists: 1050 Table 'notifications' already exists (Connection: mysql, SQL: create table `notifications` (`id` bigint unsigned not null auto_increment primary key, `type` varchar(255) not null, `notifiable_type` varchar(255) not null, `notifiable_id` bigint unsigned not null, `data` text not null, `read_at` timestamp null, `created_at` timestamp null, `updated_at` timestamp null) default character set utf8mb4 collate 'utf8mb4_unicode_ci')

  at C:\Users\Administrator\Herd\pengantar_desa\vendor\laravel\framework\src\Illuminate\Database\Connection.php:824
    820▕                     $this->getName(), $query, $this->prepareBindings($bindings), $e
    821▕                 );
    822▕             }
    823▕
  ➜ 824▕             throw new QueryException(
    825▕                 $this->getName(), $query, $this->prepareBindings($bindings), $e
    826▕             );
    827▕         }
    828▕     }

  1   C:\Users\Administrator\Herd\pengantar_desa\vendor\laravel\framework\src\Illuminate\Database\Connection.php:570
      PDOException::("SQLSTATE[42S01]: Base table or view already exists: 1050 Table 'notifications' already exists")

  2   C:\Users\Administrator\Herd\pengantar_desa\vendor\laravel\framework\src\Illuminate\Database\Connection.php:570
      PDOStatement::execute()

PS C:\Users\Administrator\herd\pengantar_desa> 