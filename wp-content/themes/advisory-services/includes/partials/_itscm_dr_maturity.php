<div class="card">
    <div class="row">
        <div class="col-sm-12">
            <div style="text-align:center; padding: 10px 25px 10px 77px;"><img src="<?php echo P3_TEMPLATE_URI; ?>/images/dashboard/dr_maturity_trend_analysis.png"></div>
            <div class="embed-responsive embed-responsive-16by9 dr-chart">
                <canvas class="embed-responsive-item" id="surveyChartDr"></canvas>
            </div>
            <ul class="list-inline drmTrendAnalysisXAxis">
                <li class="organizational_readiness"><img title="Organizational Readiness" src="<?php echo P3_TEMPLATE_URI; ?>/images/current_metrics/drm/organizational_readiness.png"></li>
                <li class="technology_readiness"><img title="Technology Readiness" src="<?php echo P3_TEMPLATE_URI; ?>/images/current_metrics/drm/technology_readiness.png"></li>
                <li class="recovery_planning"><img title="Recovery Planning" src="<?php echo P3_TEMPLATE_URI; ?>/images/current_metrics/drm/recovery_planning.png"></li>
                <li class="maintenance_sand_improvement"><img title="Maintenance & Improvement" src="<?php echo P3_TEMPLATE_URI; ?>/images/current_metrics/drm/maintenance_sand_improvement.png"></li>
            </ul>
        </div>
    </div>
</div>