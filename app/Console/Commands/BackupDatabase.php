<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Telegram\Bot\Laravel\Facades\Telegram;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class BackupDatabase extends Command
{
    protected $signature = 'db:backup';
    protected $description = 'Backup the database';
    protected $backupPath;
    protected $process;

    public function __construct()
    {
        parent::__construct();

        $backupDirectory = storage_path('app/backups');
        if (!file_exists($backupDirectory)) {
            mkdir($backupDirectory, 0755, true); // Create the directory if it doesn't exist
        }

        $this->backupPath = $backupDirectory . '/backup-' . date('Y-m-d_H-i-s') . '.sql';

        // Specify the path to mysqldump based on the operating system
        $mysqldumpPath = (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') ? 'C:\\xampp\\mysql\\bin\\mysqldump.exe' : '/usr/bin/mysqldump';

        $username = config('database.connections.mysql.username');
        $password = config('database.connections.mysql.password');
        $database = config('database.connections.mysql.database');

        if ($password) {
            $command = sprintf('%s -u%s -p%s %s > %s', $mysqldumpPath, $username, $password, $database, $this->backupPath);
        } else {
            $command = sprintf('%s -u%s %s > %s', $mysqldumpPath, $username, $database, $this->backupPath);
        }

        $this->process = Process::fromShellCommandline($command);
    }

    public function handle()
    {
        try {
            $this->process->mustRun();
            $this->info('The backup has been completed successfully.');

            // Get backup file details
            $backupDetails = $this->getBackupDetails();

            // Get length of the code
            $codeLength = $this->getCodeLength();

            // Send the backup file to Telegram
            // $this->sendBackupToTelegram($backupDetails, $codeLength);
        } catch (ProcessFailedException $exception) {
            $this->error('The backup process has failed: ' . $exception->getMessage());
        } catch (\Exception $exception) {
            $this->error('An error occurred: ' . $exception->getMessage());
        }
    }

    protected function getBackupDetails()
    {
        $fileSize = filesize($this->backupPath);
        $fileSizeKB = round($fileSize / 1024, 2); // Size in KB
        $fileCreationDate = date('Y-m-d H:i:s', filemtime($this->backupPath)); // Date of creation
        $fileLength = exec('wc -l ' . $this->backupPath); // Number of lines in the file

        return compact('fileSizeKB', 'fileCreationDate', 'fileLength');
    }

    protected function getCodeLength()
    {
        $filePath = __FILE__;
        $codeLength = count(file($filePath));

        return $codeLength;
    }

    // protected function sendBackupToTelegram($backupDetails, $codeLength)
    // {
    //     Telegram::sendDocument([
    //         'chat_id' => '-1002240460596',
    //         'document' => fopen($this->backupPath, 'r'),
    //         'caption' => "📁 Backup file\n\n📆 Date: {$backupDetails['fileCreationDate']}\n\n⚖️ Size: {$backupDetails['fileSizeKB']} KB\n\n🧾 Code length: $codeLength lines"
    //     ]);

    //     $this->info('Backup file sent to Telegram successfully.');
    // }
}
