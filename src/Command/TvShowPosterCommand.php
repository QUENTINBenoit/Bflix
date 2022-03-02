<?php

namespace App\Command;

use App\Repository\TvshowRepository;
use App\Service\OmdbApi;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'tvshow:poster',
    description: 'Mise à jour des affiches de toutes les séries',
)]
class TvShowPosterCommand extends Command
{
    // Création d'un constructeur car on ne peut injecter plus de deux dependence dans la méthode ci dessous 
    public function __construct(
        private TvshowRepository $tvshowRepository,
        private OmdbApi $omdbApi,
        private ManagerRegistry $doctrine
    ) {
        parent::__construct();
    }

    // Mise a jour de la serie per un id 
    protected function configure(): void
    {
        $this
            ->addArgument('tvshowId', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('Maj', null, InputOption::VALUE_NONE, 'Option description');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $tvshowId = $input->getArgument('tvshowId');

        if ($tvshowId) {
            $io->note(sprintf('Série neméro: %s', $tvshowId));
        }

        // Je récupère la ou les séries à mettre à jours
        $tvshowList = $this->tvshowRepository->findAll();
        // Pour chaque série je récupère les information de omdmApi
        // en fonction du title
        foreach ($tvshowList as $tvshow) {
            $title = $tvshow->getTitle();
            $tvshowData = $this->omdbApi->fetch($title);
            if (isset($tvshowData['Poster'])) {
                $tvshow->setPoster($tvshowData['Poster']);
            }
        }
        // Je met à jour la base de donnes
        $this->doctrine->getManager()->flush();
        $io->success('Mise a jours des affiches de toutes les séries.');

        return Command::SUCCESS;
    }
}
