<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Order;
use App\Entity\Contact;
use App\Entity\Product;
use App\Entity\Category;
use App\Entity\Reassurance;
use App\Entity\SectionHome;
use App\Entity\Section1Home;
use App\Entity\SliderHeader;
use App\Entity\Transporteur;
use App\Entity\ReassuranceLeft;
use App\Entity\Role;
use App\Repository\UserRepository;
use Symfony\UX\Chartjs\Model\Chart;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;


class DashboardController extends AbstractDashboardController
{
  protected ProductRepository $productRepository;
  protected UserRepository $userRepository;
  protected EntityManagerInterface $entityManager;
  /**
   * @var ChartBuilderInterface
   */
  private ChartBuilderInterface $chartBuilder;

  public function __construct(ProductRepository $postsRepository, UserRepository $userRepository, EntityManagerInterface $entityManager, ChartBuilderInterface  $chartBuilder)
  {
    $this->productRepository = $postsRepository;
    $this->userRepository = $userRepository;
    $this->entityManager = $entityManager;
    $this->chartBuilder = $chartBuilder;
  }
  public function configureAssets(): Assets
  {
    return parent::configureAssets()
      ->addWebpackEncoreEntry('app');
  }


  #[Route('/admin', name: 'admin')]
  public function index(): Response
  {

    $users = $this->entityManager->getRepository(User::class)->createQueryBuilder('u')
      ->select('count(u.id)')
      ->getQuery()
      ->getSingleScalarResult();

    $products = $this->entityManager->getRepository(Product::class)->createQueryBuilder('p')
      ->select('count(p.id)')
      ->getQuery()
      ->getSingleScalarResult();

    $userChart = $this->chartBuilder->createChart(Chart::TYPE_PIE);
    $userChart->setData([
      'labels' => ['Utilisateurs'],
      'datasets' => [
        [
          'label' => 'Utilisateurs',
          'backgroundColor' => 'rgb(255, 99, 132)',
          'borderColor' => 'rgb(255, 99, 132)',
          'data' => [$users],
        ],
      ],
    ]);
    $option = [
      'responsive' => true,
      'maintainAspectRatio' => false,
      'title' => [
        'display' => true,
        'text' => 'My Chart Title',
        'fontSize' => 18,
      ],
      'legend' => [
        'position' => 'bottom',
        'labels' => [
          'fontSize' => 14,
          'fontStyle' => 'bold',
        ],
      ],
      'scales' => [
        'xAxes' => [
          [
            'ticks' => [
              'beginAtZero' => true,
              'fontSize' => 14,
            ],
            'scaleLabel' => [
              'display' => true,
              'labelString' => 'X Axis Label',
              'fontSize' => 16,
            ],
          ],
        ],
        'yAxes' => [
          [
            'ticks' => [
              'beginAtZero' => true,
              'fontSize' => 14,
            ],
            'scaleLabel' => [
              'display' => true,
              'labelString' => 'Y Axis Label',
              'fontSize' => 16,
            ],
          ],
        ],
      ],
    ];
    $userChart->setOptions($option);

    $productChart = $this->chartBuilder->createChart(Chart::TYPE_BAR);
    $productChart->setData([
      'labels' => ['Produits'],
      'datasets' => [
        [
          'label' => 'Produits',
          'backgroundColor' => 'rgb(54, 162, 235)',
          'borderColor' => 'rgb(54, 162, 235)',
          'data' => [$products],
        ],
      ],
    ]);
    $options = [
      'responsive' => true,
      'maintainAspectRatio' => false,
      'title' => [
        'display' => true,
        'text' => 'My Chart Title',
        'fontSize' => 18,
      ],
      'legend' => [
        'position' => 'bottom',
        'labels' => [
          'fontSize' => 14,
          'fontStyle' => 'bold',
        ],
      ],
      'scales' => [
        'xAxes' => [
          [
            'ticks' => [
              'beginAtZero' => true,
              'fontSize' => 14,
            ],
            'scaleLabel' => [
              'display' => true,
              'labelString' => 'X Axis Label',
              'fontSize' => 16,
            ],
          ],
        ],
        'yAxes' => [
          [
            'ticks' => [
              'beginAtZero' => true,
              'fontSize' => 14,
            ],
            'scaleLabel' => [
              'display' => true,
              'labelString' => 'Y Axis Label',
              'fontSize' => 16,
            ],
          ],
        ],
      ],
    ];
    $productChart->setOptions($options);



    $userProductData = [
      'labels' => ['Utilisateurs', 'Produits'],
      'datasets' => [
        [
          'label' => 'Nombre',
          'data' => [$users, $products],
          'backgroundColor' => ['rgb(255, 99, 132)', 'rgb(54, 162, 235)'],
        ],
      ],
    ];

    $userProductChart = $this->chartBuilder->createChart(Chart::TYPE_PIE);
    $userProductChart->setData($userProductData);
    $userProductChart->setOptions([
      'responsive' => true,

      'title' => [
        'display' => true,
        'text' => 'Nombre total d\'utilisateurs et de produits',
        'fontSize' => 18,
      ],
      'legend' => [
        'position' => 'bottom',
        'labels' => [
          'fontSize' => 14,
          'fontStyle' => 'bold',
        ],
      ],
    ]);


    return $this->render('bundles/EasyAdminBundle/welcome.html.twig', [
      'countPost' => $this->productRepository->countPost(),
      'countUser' => $this->userRepository->countUser(),
      'userChart' => $userChart,
      'productChart' => $productChart,
      'userProductChart' => $userProductChart,
      // 'chartData' => $this->createChart(),
      'users' => $users,
      'products' => $products,

    ]);
  }
  private function createChart(): Chart
  {
    $chart = $this->chartBuilder->createChart(Chart::TYPE_LINE);
    $chart->setData([
      'labels' => ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
      'datasets' => [
        [
          'label' => 'My First dataset',
          'backgroundColor' => 'rgb(0, 0, 0)',
          'borderColor' => 'rgb(0, 0, 0)',
          'data' => [0, 10, 5, 2, 20, 30, 45],
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
    return $chart;
  }

  public function configureDashboard(): Dashboard
  {
    return Dashboard::new()
      ->setTitle('La French Boutique');
  }
  public function configureCrud(): Crud
  {
    return parent::configureCrud()
      ->showEntityActionsInlined();
  }

  public function configureMenuItems(): iterable
  {
    return [
      MenuItem::linkToDashboard('Dashboard', 'fa fa-home'),
      MenuItem::linkToCrud('Utilisateurs', 'fas fa-user', User::class),
      // MenuItem::linkToCrud('Roles', 'fa fa-truck', Role::class),
      MenuItem::linkToCrud('Categories', 'fa-solid fa-list', Category::class),
      MenuItem::linkToCrud('Produits', 'fa fa-tag', Product::class),
      MenuItem::linkToCrud('Transporteurs', 'fa fa-truck', Transporteur::class),
      MenuItem::linkToCrud('Commandes', 'fa fa-shopping-cart', Order::class),
      MenuItem::linkToCrud('Slider', 'fa fa-desktop', SliderHeader::class),
      MenuItem::linkToCrud('sectionHome', 'fa fa-desktop', SectionHome::class),
      MenuItem::linkToCrud('section1Home', 'fa fa-desktop', Section1Home::class),
      MenuItem::linkToCrud('réassurance', 'fa fa-desktop', Reassurance::class),
      MenuItem::linkToCrud('réassurance-gauche', 'fa fa-desktop', ReassuranceLeft::class),
      MenuItem::linkToCrud('Formulaire', 'fa fa-envelope', Contact::class),
    ];
  }
}
