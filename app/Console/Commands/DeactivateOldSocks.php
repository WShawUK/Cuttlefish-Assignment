<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;

//
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Support\Collection;

class DeactivateOldSocks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:deactivate-old-socks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deactivates products in the socks category that are older than 2 years';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $oldSocks = Product::where('category_id', '3')
            ->where('created_at', '<', now()->subYears(2))
            ->where('is_active', true)
            ->get();
        
        if ($oldSocks->isEmpty()) {
            $this->info('No active old socks found');
            return;
        }

        $this->info('The following are active old socks: ');
        foreach ($oldSocks as $product) {
            echo $product->name, "\n";
            $product->update(['is_active'=> false]);
        }
        $this->info('And are now deactivated');
    }
}
