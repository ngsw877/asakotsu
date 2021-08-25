<?php

namespace App\Console\Commands\User;

use App\Repositories\User\UserRepositoryInterface;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SoftDeleteUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:soft-delete-user {userId}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '指定したアカウントを論理削除します。';

    private UserRepositoryInterface $userRepository;

    /**
     * Create a new command instance.
     *
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        parent::__construct();
        $this->userRepository = $userRepository;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     * @throws Exception
     */
    public function handle(): int
    {
        $userId = $this->argument('userId');

        $user = $this->userRepository->find($userId);

        DB::beginTransaction();

        try {
            $this->userRepository->delete($user);
            DB::commit();

            echo 'アカウント「' . $user->name . '」を論理削除しました。' . PHP_EOL;
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            throw $e;
        }

        return 0;
    }
}
