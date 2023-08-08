<div class="adequate_es ">
    <div class="form-group col-md-12">
        @include('layouts.partials.reviewers')
    </div>
    <div class="form-group col-md-12">
        <label for="admin"></label>
        <div class="i-checks">
            <label for="npdes-required">
                <input type="checkbox" name="npdes_required"
                       value="THE BUCKS COUNTY CONSERVATION DISTRICT IS REQUIRING AN NPDES PERMIT FOR THIS PROJECT.  NO EARTHMOVING MAY BEGIN UNTIL THE NPDES PERMIT HAS BEEN OBTAINED."
                       id="npdes-required"> <i class="ml-1"></i>
                NPDES Required </label>
        </div>
    </div>
    <div class="form-group col-md-12">
        <label for="admin"></label>
        <div class="i-checks">
            <label for="preconstruction">
                <input type="checkbox"
                       value="A preconstruction meeting is requested by the BCCD.  No earthmoving may begin until the pre-construction meeting has taken place."
                       name="preconstruction" id="preconstruction"> <i
                        class="ml-1"></i>
                Preconstruction Required </label>
        </div>
    </div>
    <div class="form-group col-md-12">
        <label for="sheets">Sheets</label>
        <input type="text" class="form-control" id="sheets" name="sheets">
    </div>
</div>
