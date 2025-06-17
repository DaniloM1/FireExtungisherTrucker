<?php
// app/Console/Commands/PruneAttachments.php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Attachment;
use Carbon\Carbon;

class PruneAttachments extends Command
{
    protected $signature = 'attachments:prune {days=30}';
    protected $description = 'Trajno briše soft deleted priloge starije od X dana.';

    public function handle()
    {
        $days = $this->argument('days');
        $count = 0;
        $attachments = Attachment::onlyTrashed()
            ->where('deleted_at', '<', Carbon::now()->subDays($days))
            ->get();

        foreach ($attachments as $att) {
            \Storage::disk('public')->delete($att->path);
            $att->forceDelete();
            $count++;
        }

        $this->info("Obrisano $count priloga.");
    }
}

