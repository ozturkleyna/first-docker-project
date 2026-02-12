<?php
// Bu satır Composer'ın indirdiği her şeyi projeye dahil eder
require_once 'vendor/autoload.php';

use Doctrine\DBAL\DriverManager;

// Veritabanı bağlantı bilgileri
$connectionParams = [
    'dbname' => 'test_db',
    'user' => 'root',
    'password' => 'root',
    'host' => 'db',
    'driver' => 'pdo_mysql',
];

try {
    // DBAL ile bağlantı oluşturuyoruz
    $conn = DriverManager::getConnection($connectionParams);
    
    echo "<h1>🚀 Symfony DBAL Başarıyla Bağlandı!</h1>";

    // Örnek: Veritabanında bir tablo oluşturalım (Eğer yoksa)
    $conn->executeStatement("CREATE TABLE IF NOT EXISTS notlar (
        id INT AUTO_INCREMENT PRIMARY KEY,
        mesaj VARCHAR(255) NOT NULL
    )");

    // Örnek: Veritabanına bir veri ekleyelim
    $conn->insert('notlar', ['mesaj' => 'Selam Hollanda, ben geliyorum!']);

    // Örnek: Verileri çekelim (Query Builder mantığı)
    $queryBuilder = $conn->createQueryBuilder();
    $notlar = $queryBuilder
        ->select('mesaj')
        ->from('notlar')
        ->executeQuery()
        ->fetchAllAssociative();

    echo "<h3>Veritabanındaki Notlar:</h3>";
    foreach ($notlar as $not) {
        echo "- " . $not['mesaj'] . "<br>";
    }

} catch (\Exception $e) {
    echo "Hata oluştu: " . $e->getMessage();
}