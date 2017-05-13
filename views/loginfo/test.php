<?php
use miloschuman\highcharts\Highcharts;
use miloschuman\highcharts\SeriesDataHelper;
                      $data[0] = ['name' => 'jcm', 'data' => [15, 70, 35,75,1]];
                      $data[1] = ['name' =>'reboot','data'=> [1,12,34,56]];
                      ksort($data);
        echo  Highcharts::widget([
        'options' => [
                   'title' => ['text' => 'user login'],
                   'credits' => ['enabled' => false],
                   'xAxis' => [
                            'categories' =>$date,
                              ],
                   'yAxis' => [
                             'title' => ['text' => 'count']
                              ],
                   'series' =>$user 
                      ] 
           ]);
        print_r($user);
        print_r("<br/>");
        print_r($data);

