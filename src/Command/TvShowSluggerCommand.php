<?php

namespace App\Command;

use App\Repository\TvshowRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\String\Slugger\SluggerInterface;

#[AsCommand(
    name: 'tvshow:slugger',
    description: 'Creation de slugs pour une ou plusieurs series',
)]
class TvShowSluggerCommand extends Command
{
    public function __construct(
        public EntityManagerInterface $doctrine,
        public TvshowRepository $tvshowRepository,
        public SluggerInterface $slugger,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('tvshowId', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('updatedAt', null, InputOption::VALUE_NONE, 'Option description');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $tvshowId = $input->getArgument('tvshowId');
        $optionUpdatedAt = $input->getOption('updatedAt');

        if ($optionUpdatedAt) {
            //  $io->note(sprintf('You passed an argument: %s', $arg1));
        }

        if ($tvshowId) {
            $tvshow = $this->tvshowRepository->find($tvshowId);
            $this->saveSlug($tvshow, $optionUpdatedAt);
        } else {

            // On met à jour toutes les séries
            $tvShowList = $this->tvshowRepository->findAll();
            foreach ($tvShowList as $currentTvShow) {
                $this->saveSlug($currentTvShow, $optionUpdatedAt);
            }
        }
        // 5) On flush avec le manager
        $this->doctrine->flush();
        $io->success('Toutes les séries ont bien été mis a jour.');

        return Command::SUCCESS;
    }
    private function saveSlug($tvshow, $optionUpdatedAt)
    {
        $title = $tvshow->getTitle();
        $slug = $this->slugger->slug($title);
        $tvshow->setSlug(\strtolower($slug));
        if ($optionUpdatedAt) {
            $tvshow->setUpdatedAt(new DateTime());
        }
    }
}
