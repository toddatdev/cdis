<div class="compliance_notice dependent-list-item ">
    <div class="form-group col-md-12">
        @include('layouts.partials.reviewers')
    </div>
    <div class="form-group col-md-12">
        <label for="admin" class="font-bold">Compliance Notice Sent After
        </label>
        <div class="i-checks mt-2">
            <label class="checkbox-inline">
                <input type="radio" value="Please be advised that the Conservation District and/or representatives of the Department will conduct additional inspections of the site.  If future inspections reveal that required corrective actions have not been made and additional violations have occurred, the conservation District may initiate enforcement action." name="compliance_notice" checked>
                <i class="ml-1"></i> First Inspection
            </label>
            <label class="ml-2">
                <input type="radio"
                       value="Reference is made to the previous inspection report dated 00/00/00 for this site wherein violations of the Rules and Regulations and the Clean Streams Law were also documented.  Please be advised that the Conservation District and/or representatives of the Department will conduct additional inspections of the site.  If future inspections reveal that required corrective actions have not been made and additional violations have occurred, the Conservation District may initiate enforcement action."
                       name="compliance_notice"> <i class="ml-1"></i> Second Inspection</label>
        </div>
    </div>
    <div class="form-group col-md-12">
        <label for="admin"></label>
        <div class="i-checks">
            <label for="admin">
                <input type="checkbox" name="es_plan_request"
                       value="Reference is made to the previous inspection report dated 00/00/00 for this site wherein violations of the Rules and Regulations and the Clean Streams Law were also documented.  Please be advised that the Conservation District and/or representatives of the Department will conduct additional inspections of the site.  If future inspections reveal that required corrective actions have not been made and additional violations have occurred, the Conservation District may initiate enforcement action."
                       id="admin"> <i class="ml-1"></i> Requesting E&S Plan
            </label>
        </div>
    </div>
</div>
