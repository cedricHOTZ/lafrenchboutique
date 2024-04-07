<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Product;
use App\Entity\Reassurance;
use App\Entity\SectionHome;
use App\Entity\Section1Home;
use App\Entity\SliderHeader;
use App\Entity\ReassuranceLeft;
use Symfony\UX\Chartjs\Model\Chart;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends AbstractController
{

    /**
     * @var ChartBuilderInterface
     */
    private ChartBuilderInterface $chartBuilder;


    public function __construct(ChartBuilderInterface  $chartBuilder)
    {

        $this->chartBuilder = $chartBuilder;
    }
    /**
     * @Route("/", name="app_home",methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManagerInterface, ChartBuilderInterface  $chartBuilder, Request $request): Response
    {

        $users = $entityManagerInterface->getRepository(User::class)->createQueryBuilder('u')
            ->select('count(u.id)')
            ->getQuery()
            ->getSingleScalarResult();

        $products = $entityManagerInterface->getRepository(Product::class)->createQueryBuilder('p')
            ->select('count(p.id)')
            ->getQuery()
            ->getSingleScalarResult();


        $chart = $this->chartBuilder->createChart(Chart::TYPE_LINE);


        $chart->setData([
            'labels' => ['user'],
            'datasets' => [
                [
                    'label' => 'user', 'product',
                    'backgroundColor' => 'rgb(255, 99, 132)',
                    'borderColor' => 'rgb(255, 99, 132)',
                    'data' => [$users],
                ],
            ],
        ]);

        $chart->setOptions([
            'scales' => [
                'y' => [
                    'suggestedMin' => 0,
                    'suggestedMax' => 100,
                ],
            ],
        ]);
        $sectionHome = $entityManagerInterface->getRepository(SectionHome::class)->findAll();
        $section1Home = $entityManagerInterface->getRepository(Section1Home::class)->findAll();
        $reassurance = $entityManagerInterface->getRepository(Reassurance::class)->findAll();
        $reassuranceLeft = $entityManagerInterface->getRepository(ReassuranceLeft::class)->findAll();
        $isBest = $entityManagerInterface->getRepository(Product::class)->findByIsBest(1);
        $slider = $entityManagerInterface->getRepository(SliderHeader::class)->findAll();;

        $session = $request->getSession();
        // Vérifier si le loader a déjà été affiché pendant cette session
        $loaderDisplayed = $session->get('loaderDisplayed');
        if ($loaderDisplayed) {
            $showLoader = false;
        } else {
            $session->set('loaderDisplayed', true);
            $showLoader = true;
        }




        return $this->render('home/index.html.twig', [
            'isBest' => $isBest,
            // 'showLoader' => $showLoader,
            'slider' => $slider,
            'sectionHome' => $sectionHome,
            'section1Home' => $section1Home,
            'reassurance' => $reassurance,
            'reassuranceLeft' => $reassuranceLeft,
            'chart' => $chart,
        ]);
    }
}
