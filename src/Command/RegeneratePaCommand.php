<?php
declare(strict_types=1);

namespace App\Command;

use Cake\Command\Command;
use Cake\Console\Arguments;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;

/**
 * RegeneratePa command.
 */
class RegeneratePaCommand extends Command
{
    /**
     * The name of this command.
     *
     * @var string
     */
    protected string $name = 'regenerate_pa';

    /**
     * Get the default command name.
     *
     * @return string
     */
    public static function defaultName(): string
    {
        return 'regenerate_pa';
    }

    /**
     * Get the command description.
     *
     * @return string
     */
    public static function getDescription(): string
    {
        return 'Régénère +5 points d\'action toutes les minutes pour les parties de labyrinthe (max 15).';
    }

    /**
     * Hook method for defining this command's option parser.
     *
     * @link https://book.cakephp.org/5/en/console-commands/commands.html#defining-arguments-and-options
     * @param \Cake\Console\ConsoleOptionParser $parser The parser to be defined
     * @return \Cake\Console\ConsoleOptionParser The built parser.
     */
    public function buildOptionParser(ConsoleOptionParser $parser): ConsoleOptionParser
    {
        return parent::buildOptionParser($parser)
            ->setDescription(static::getDescription());
    }

    /**
     * Implement this method with your command's logic.
     *
     * @param \Cake\Console\Arguments $args The command arguments.
     * @param \Cake\Console\ConsoleIo $io The console io
     * @return int|null|void The exit code or null for success
     */
    public function execute(Arguments $args, ConsoleIo $io)
    {
        $sessionsTable = $this->fetchTable('GameSessions');
        
        // Ajoute +5 PA à toutes les sessions du jeu Labyrinthe sans dépasser 15
        $query = $sessionsTable->query();
        $query->update()
            ->set([
                'pa' => $query->newExpr('LEAST(pa + 5, 15)')
            ])
            ->where([
                'game_id' => 3, // FIXME: L'ID 3 doit correspondre à l'ID du jeu Labyrinthe
                'pa <' => 15
            ])
            ->execute();

        $io->success('Points d\'action (PA) régénérés avec succès pour les joueurs du Labyrinthe.');
        
        return static::CODE_SUCCESS;
    }
}
