<?php
$list = "1. Construction Sequence- The construction sequence should contain the information needed for the staging of earthmoving/work activities. Please address upon resubmission.\n §102.11(a)(1)
-2. Standard Notes- All BCCD Standard Notes should be included on the erosion and sediment control plan. Please address upon resubmission.\n§ 102.11(a)(1)
-3. Silt Fence Detail - Silt fence should be located on the down-slope side of the site disturbance. Detail is not included on the plan. Correct detail is located in DEP Erosion and Sediment Pollution Control Manual. Please address upon resubmission.\n§ 102.11(a)(1)
-4. Rock Filter Outlet- There is no detail maintenance note for rock filter outlet on plan. The DEP detail and maintenance note for a rock filter outlet in silt fence is needed by the silt fence detail. Please address upon resubmission.\n§102.11(a)(1)
-5. Seeding, Mulching, Fertilizer, Liming Types/Rates- Need details. Please address upon resubmission.\n§102.11(a)(1)
-6. Soils- Need to identify soil type to exclude presence of hydric soils. (Soil Types listed at www.bucksccd.org).\n§102.11(a)(1)
-7. Limit of Disturbance- Limit of disturbance not shown in legend. This line needs to be represented on plan, include all the areas of work, driving paths, utilities, staging areas and also include all erosions controls installed on the site. Please address upon resubmission.\n§102.11(a)(1)
-8. Rock Construction Entrance- Rock Construction Entrance, needs to be represented on the plan with DEP maintenance notes/details. For example, location, rock type, measurements, will keep road clean, etc. If using pre-existing driveway a note stating this and that the roads will be kept free of sediment should be on the plan. Please address upon resubmission.\n§102.11(a)(1)
-9. PA One Call Symbol- The erosion and sediment control plan should include the Symbol, Phone Number and Site Specific Serial Number. Please address upon resubmission.\n§102.11(a)(1)
-10. Location Map- The erosion and sediment control plan should include a location map. It needs to clearly show location of site. For example streets, directions, north arrow, etc… Please address upon resubmission.\n§102.11(a)(1)
-11. Contours- The plan needs to show the contours. BCCD recommends 2 foot intervals. This shows the slope to which way the water will flow off the site. Please address upon resubmission\n§102.11(a)(1)
-12. Inlet Protection- The erosion and sediment control plan should include inlet protection. Correct detail is located in DEP Erosion and Sediment Pollution Control Manual. Please address upon resubmission.\n§102.11(a)(1)
-13. Sediment/filtration bag- The plan should contain the detail for a sediment/filter bag. If the trenches for the footings fill with water during a rain event the sediment laden water must be pumped through a sediment bag on a stabilized surface. Correct detail is located in DEP Erosion and Sediment Pollution Control Manual. Please address upon resubmission.\n§102.11(a)(1)";


$options = explode("\n-", $list);
?>


<div class="inadequate_npdes dependent-list-item ">
    <div class="form-group col-md-12">
        @include('layouts.partials.reviewers')
    </div>
    <div class="form-group col-md-12" id="inadequate-npdes">
        <label for="admin"></label>
        <div class="i-checks">
            <label for="admin">
                <input type="checkbox" class="check-all" value="1" id="admin"> <i class="ml-1"></i>
                <strong>Check All</strong></label>
        </div>
    </div>
    @foreach($options as $key => $option)
        <div class="form-group col-md-12">
       {{--     <label for="admin"></label>
            <div class="i-checks">
                <label for="ch-{{$key}}">
                    <input type="checkbox" class="cbi" value="{{$option}}" id="cb-{{$key}}" name="deficiencies[]"> <i
                        class="ml-1"></i> {{$option}}
                </label>
            </div>
--}}

            <div class="checks">
                <label class="a-checks" id="cb-{{$key}}">
                    <input type="checkbox" class="cbi" value="{{$option}}" id="cb-{{$key}}"
                           name="deficiencies[]" {{($project->projectPermit->is_notice_received?? '')? 'checked' : ''}}>
                    <span class="checkmark"></span> {{$option}}
                </label>
            </div>

        </div>
    @endforeach
</div>
