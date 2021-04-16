<?php

namespace App\Charts;

use ConsoleTVs\Charts\Classes\Chartjs\Chart;
use Mockery\Container;

class ContainerDistanceChart extends Chart
{
    /**
     * Initializes the chart. And sets the settings for this chart
     *
     * @param $labels
     * @param $data
     */
    public function __construct($labels, $data)
    {
        $this->setChartLayout();
        $this->setChartTitle();
        $this->notShowingLegend();

        $this->labels($labels);
        $this->dataset('Distance from container', 'line', $data)
            ->color("#DC3545")
            ->linetension(0.5)
            ->backgroundcolor('rgba(255, 255, 255, 0.0)');

        parent::__construct();
    }

    /**
     * @return ContainerDistanceChart
     */
    public function setChartLayout(): ContainerDistanceChart
    {
        return $this->options([
            'scales' => [
                'xAxes' => [['ticks' => ['fontColor' => 'white']]],
                'yAxes' => [['ticks' => ['fontColor' => 'white']]]
            ]
        ]);
    }

    /**
     * @return ContainerDistanceChart
     */
    public function setChartTitle(): ContainerDistanceChart
    {
        return $this->title('Container distance', '20', '#FFF');
    }

    /**
     *
     */
    public function notShowingLegend() : ContainerDistanceChart
    {
        return $this->displayLegend(false);
    }
}
