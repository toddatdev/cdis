<div class="general_permit_incompleteness dependent-list-item ">
    <div class="row px-3">
        <div class="form-group col-md-4">
            @include('layouts.partials.reviewers')
        </div>
        <div class="form-group col-md-12">
            <div class="i-checks">
                <label for="pag01">
                    <input type="checkbox" name="pag0"
                           value="Individual NPDES Permit" id="pag01"/>
                    <i class="ml-1"></i>
                    <p class="d-inline">Individual NPDES Permit</p>
                </label>
            </div>
            <div class="i-checks">
                <label for="pag02">
                    <input type="checkbox" name="pag1"
                           value="Erosion and Sediment Control General Permit coverage" id="pag02"/>
                    <i class="ml-1"></i>
                    <p class="d-inline">Erosion and Sediment Control General Permit coverage</p>
                </label>
            </div>
            <div class="i-checks">
                <label for="pag03">
                    <input type="checkbox" name="pag2"
                           value="Individual Erosion and Sediment Control Permit" id="pag03"/>
                    <i class="ml-1"></i>
                    <p class="d-inline">Individual Erosion and Sediment Control Permit</p>
                </label>
            </div>
        </div>
        <div class="form-group col-md-12">
            <div class="i-checks">
                <label>
                    <input type="checkbox" name="dep_has_developed"
                           value="DEP has developed a standardized review process and processing times for all permits or other authorizations that it issues or grants.  Pursuant to its Permit Review Process and Permit Decision Guarantee Policy (Document # 021-2100-001), DEP guarantees to provide permit decisions within the published time frames, provided applicants submit complete, technically adequate applications/registrations that address all applicable regulatory and statutory requirements, in the first submission.  Since you did not submit a complete and/or technically adequate application, DEP’s Permit Decision Guarantee is no longer applicable to your application.">
                    <i class="ml-1"></i>
                    <p class="d-inline">
                        <span class="font-weight-bold">(OPTIONAL - Use this paragraph only for Individual Permits And ESCGP NOIs)</span><br/>
                        DEP has developed a standardized review process and processing times for all permits or other authorizations that it issues or grants.  Pursuant to its Permit Review Process and Permit Decision Guarantee Policy (Document # 021-2100-001), DEP guarantees to provide permit decisions within the published time frames, provided applicants submit complete, technically adequate applications/registrations that address all applicable regulatory and statutory requirements, in the first submission.  Since you did not submit a complete and/or technically adequate application, DEP’s Permit Decision Guarantee is no longer applicable to your application.
                    </p>
                </label>
            </div>
        </div>
        <div class="form-group col-md-12">
            <div class="i-checks">
                <label>
                    <input type="checkbox" name="please_note"
                           value="Please note, the permit number for this project has been updated to conform to U.S. Environmental Protection Agency (EPA) requirements. All future correspondence will reference this new permit number.">
                    <i class="ml-1"></i>
                    <p class="d-inline">
                        <span class="font-weight-bold">(OPTIONAL - Use this paragraph only for permit renewals and major amendments after August 17, 2016 for non-PAD-numbered permits)</span><br/>
                        Please note, the permit number for this project has been
                        updated to conform to U.S. Environmental Protection Agency (EPA) requirements. All future
                        correspondence will reference this new permit number.
                    </p>
                </label>
            </div>
        </div>
        <div class="form-group col-md-12">
            <label for="check-all"></label>
            <div class="i-checks">
                <label for="admin">
                    <input type="checkbox" class="check-all" value="1"> <i class="ml-1"></i>
                    <strong>Check All</strong>
                </label>
            </div>
        </div>
        <div class="col-md-12">
            <div class="i-checks">
                <label for="cb-1">
                    <input type="checkbox" class="cbi"
                           value="1. One original and one copy of the complete NOI form (3800-PM-BCW0405b) were not\r\n     submitted and were not completed as instructed in the PAG-02 NOI Instructions.\r\n     Please address. [25 Pa. Code § 102.6(a)(1)]\r"
                           id="cb-1" name="options[]"> <i class="ml-1"></i> <span>1. One original and one copy of the
                    complete NOI form (3800-PM-BCW0405b) were not submitted and were not completed as instructed in
                    the
                    PAG-02 NOI Instructions. Please address. [25 Pa. Code § 102.6(a)(1)]
                    </span>
                </label>
            </div>
            <ol class="list-unstyled" style="padding-left: 30px">
                <li>
                    <div class="form-group i-checks">
                        <label for="cb-1-a">
                            <input type="checkbox" class="cbi cbic"
                                   value="a. All eligibility requirements of PAG-02 as specified in Section III.B of the General Permit\r\n        do not appear to be met.  Please address. [25 Pa. Code § 102.6(a)(1)]"
                                   id="cb-1-a" name="options[][]" data-parent-id="cb-1"> <i class="ml-1"></i>a. All
                            eligibility
                            requirements of PAG-02 as specified in Section III.B of the General Permit do not appear
                            to be met. Please address. [25 Pa. Code § 102.6(a)(1)]
                        </label>
                    </div>
                </li>
                <li>
                    <div class="form-group i-checks">
                        <label for="cb-1-b cb-1-all">
                            <input type="checkbox" class="cbi cbic"
                                   value="b. The applicant is proposing to use floodplain restoration or gravity injection wells as PCSM\r\n        BMPs.  Please address. [25 Pa. Code § 102.6(a)(1)]\r\n\r"
                                   id="cb-1-b" name="options[][]" data-parent-id="cb-1"> <i class="ml-1"></i>b. The
                            applicant is proposing
                            to use floodplain restoration or gravity injection wells as PCSM BMPs. Please address.
                            [25 Pa. Code § 102.6(a)(1)]
                        </label>
                    </div>
                </li>
            </ol>
        </div>
        <div class="form-group col-md-12">
            <div class="i-checks">
                <label for="cb-2">
                    <input type="checkbox" class="cbi"
                           value="2. 102.6(a)(1) – One original and one copy of the complete GIF (0210-PM-PIO0001)\r\n\r"
                           id="cb-2" name="options[]"> <i class="ml-1"></i>2. 102.6(a)(1) – One original and one copy of the complete GIF (0210-PM-PIO0001).
                </label>
            </div>
        </div>
        <div class="form-group col-md-12">
            <div class="i-checks">
                <label for="cb-3">
                    <input type="checkbox" class="cbi"
                           value="3. Two copies of County and Municipal Notification Forms (3800-FM-BCW0271a and\r\n     3800-FM-BCW0271b, respectively) with county and municipal signatures or proof\r\n     that the county and municipality received the forms were not submitted.\r\n     Please address. [25 Pa. Code § 102.6(a)(1)]\r\n\r"
                           id="cb-3" name="options[]"> <i class="ml-1"></i>3. Two copies of County and Municipal
                    Notification Forms (3800-FM-BCW0271a and 3800-FM-BCW0271b, respectively) with county and municipal
                    signatures or proof that the county and municipality received the forms were not submitted. Please
                    address. [25 Pa. Code § 102.6(a)(1)].
                </label>
            </div>
        </div>
        <div class="form-group col-md-12">
            <div class="i-checks">
                <label for="cb-4">
                    <input type="checkbox" class="cbi"
                           value="4. Two copies of the PNDI receipt (draft receipts not acceptable), which will not\r\n     expire prior to anticipated authorization of permit coverage, were not submitted.\r\n     Please address.  [25 Pa. Code § 102.6(a)(2)]\r\n\r"
                           id="cb-4" name="options[]"> <i class="ml-1"></i>4. Two copies of the PNDI receipt (draft
                    receipts not acceptable), options will not expire prior to anticipated authorization of permit
                    coverage, were not submitted. Please address. [25 Pa. Code § 102.6(a)(2)]
                </label>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group i-checks">
                <label for="cb-5">
                    <input type="checkbox" class="cbi"
                           value="5. Two copies of the complete E&S Module 1 (3800-PM-BCW0406a) were not submitted\r\n     and were not completed as instructed in the PAG-02 NOI Instructions.\r\n     Please address.  [25 Pa. Code § 102.6(a)(1)]\r"
                           id="cb-5" name="options[]"> <i class="ml-1"></i>5. Two copies of the complete E&S Module 1
                    (3800-PM-BCW0406a) were not submitted and were not completed as instructed in the PAG-02 NOI
                    Instructions. Please address. [25 Pa. Code § 102.6(a)(1)]
                </label>
            </div>

            <ol class="list-unstyled" style="padding-left: 30px">
                <li>
                    <div class="form-group i-checks">
                        <label for="cb-5-a">
                            <input type="checkbox" class="cbi cbic"
                                   value="a. Details were not provided for all E&S BMPs (Question 5 of E&S Plan Information).\r\n        Please address.  [25 Pa. Code § 102.4(b)(5)(ix)]"
                                   id="cb-5-a" name="options[][]" data-parent-id="cb-5"> <i class="ml-1"></i>a. Details
                            were not provided for
                            all E&S BMPs (Question 5 of E&S Plan Information). Please address. [25 Pa. Code §
                            102.4(b)(5)(ix)]
                        </label>
                    </div>
                </li>
                <li>
                    <div class="form-group i-checks">
                        <label for="cb-5-b">
                            <input type="checkbox" class="cbi cbic"
                                   value="b. Standard E&S Worksheets from the E&S Manual (or their equivalent) were not attached.\r\n        Please address.  [25 Pa. Code § 102.4(b)(5)(viii)]"
                                   id="cb-5-b" name="options[][]" data-parent-id="cb-5"> <i class="ml-1"></i>b. Standard
                            E&S Worksheets from
                            the E&S Manual (or their equivalent) were not attached. Please address. [25 Pa. Code §
                            102.4(b)(5)(viii)]
                        </label>
                    </div>
                </li>
                <li>
                    <div class="form-group i-checks">
                        <label for="cb-5-c">
                            <input type="checkbox" class="cbi cbic"
                                   value="c. Supporting E&S calculations were not provided (for any calculation not handled by a\r\n        Standard E&S Worksheet or an equivalent).   Please address.  [25 Pa. Code § 102.4(b)(5)\r\n        (viii)]"
                                   id="cb-5-c" name="options[][]" data-parent-id="cb-5"> <i class="ml-1"></i>c.
                            Supporting E&S calculations
                            were not provided (for any calculation not handled by a Standard E&S Worksheet or an
                            equivalent). Please address. [25 Pa. Code § 102.4(b)(5)(viii)]
                        </label>
                    </div>
                </li>
                <li>
                    <div class="form-group i-checks">
                        <label for="cb-5-d">
                            <input type="checkbox" class="cbi cbic"
                                   value="d. An Off-site Discharge Analysis was not provided, if applicable.   Please address.  [25 Pa.\r\n        Code § 102.4(c)]"
                                   id="cb-5-d" name="options[][]" data-parent-id="cb-5"> <i class="ml-1"></i>d. An
                            Off-site Discharge Analysis
                            was not provided, if applicable. Please address. [25 Pa. Code § 102.4(c)]
                        </label>
                    </div>
                </li>
                <li>
                    <div class="form-group i-checks">
                        <label for="cb-5-e">
                            <input type="checkbox" class="cbi cbic"
                                   value="e. If hydric soils are present, a wetland determination was not submitted.  Please address.\r\n        [25 Pa. Code § 102.4(b)(5)(v)]"
                                   id="cb-5-e" name="options[][]" data-parent-id="cb-5"> <i class="ml-1"></i>e. If
                            hydric soils are present, a
                            wetland determination was not submitted. Please address. [25 Pa. Code § 102.4(b)(5)(v)]
                        </label>
                    </div>
                </li>
                <li>
                    <div class="form-group i-checks">
                        <label for="cb-5-f">
                            <input type="checkbox" class="cbi cbic"
                                   value="f. If contaminated soils are present, documentation was not provided that pollutant levels do\r\n        not exceed residential or non-residential MSCs for soil in Chapter 250 (Appendix A,\r\n        Tables 3 and 4) for residential and non-residential sites, respectively, unless a site-specific\r\n        standard has been met under a state or federal cleanup program or the applicant provides\r\n        documentation of naturally occurring contamination.\r\n        Please address.  [25 Pa. Code § 102.4(b)(5)(xii)]\r\n\r"
                                   id="cb-5-f" name="options[][]" data-parent-id="cb-5"> <i class="ml-1"></i>f. If
                            contaminated soils are
                            present, documentation was not provided that pollutant levels do not exceed residential or
                            non-residential MSCs for soil in Chapter 250 (Appendix A, Tables 3 and 4) for residential
                            and non-residential sites, respectively, unless a site-specific standard has been met under
                            a state or federal cleanup program or the applicant provides documentation of naturally
                            occurring contamination. Please address. [25 Pa. Code § 102.4(b)(5)(xii)]
                        </label>
                    </div>
                </li>
            </ol>
        </div>
        <div class="col-md-12">
            <div class="form-group i-checks">
                <label for="cb-6">
                    <input type="checkbox" class="cbi"
                           value="6. Two sets or copies of E&S Plan Drawing(s) were not submitted.\r\n     Please address.  [25 Pa. Code § 102.4(b)(5)(ix)]\r"
                           id="cb-6" name="options[]"> <i class="ml-1"></i>6. Two sets or copies of E&S Plan
                    Drawing(s) were not submitted. Please address. [25 Pa. Code § 102.4(b)(5)(ix)]
                </label>
            </div>
            <ol class="list-unstyled" style="padding-left: 30px">
                <li>
                    <div class="form-group i-checks">
                        <label for="cb-6-a">
                            <input type="checkbox" class="cbi cbic"
                                   value="a. The Drawing(s) do not include existing and proposed topography (including any temporary\r\n        contours) with appropriate contour labels.  Please address.  [25 Pa. Code § 102.4(b)(5)(i)]"
                                   id="cb-6-a" name="options[][]" data-parent-id="cb-6"> <i class="ml-1"></i>a. The
                            Drawing(s) do not include
                            existing and proposed topography (including any temporary contours) with appropriate contour
                            labels. Please address. [25 Pa. Code § 102.4(b)(5)(i)]
                        </label>
                    </div>
                </li>
                <li>
                    <div class="form-group i-checks">
                        <label for="cb-6-b">
                            <input type="checkbox" class="cbi cbic"
                                   value="b. The Drawing(s) do not include the project site boundary.  Please address.  [25 Pa. Code\r\n        § 102.4(b)(5)(iii)]"
                                   id="cb-6-b" name="options[][]" data-parent-id="cb-6"> <i class="ml-1"></i>b. The
                            Drawing(s) do not include
                            the project site boundary. Please address. [25 Pa. Code § 102.4(b)(5)(iii)]
                        </label>
                    </div>
                </li>
                <li>
                    <div class="form-group i-checks">
                        <label for="cb-6-c">
                            <input type="checkbox" class="cbi cbic"
                                   value="c. The Drawing(s) do not include the limit of earth disturbance within the project site.  Please\r\n        address.  [25 Pa. Code § 102.4(b)(5)(iii)]"
                                   id="cb-6-c" name="options[][]" data-parent-id="cb-6"> <i class="ml-1"></i>c. The
                            Drawing(s) do not include
                            the limit of earth disturbance within the project site. Please address. [25 Pa. Code §
                            102.4(b)(5)(iii)]
                        </label>
                    </div>
                </li>
                <li>
                    <div class="form-group i-checks">
                        <label for="cb-6-d">
                            <input type="checkbox" class="cbi cbic"
                                   value="d. The Drawing(s) do not show receiving surface water(s) and watershed boundaries, if\r\n        applicable, within the project site and floodway or floodplain.\r\n        Please address.  [25 Pa. Code § 102.4(b)(5)(v)]"
                                   id="cb-6-d" name="options[][]" data-parent-id="cb-6"> <i class="ml-1"></i>d. The
                            Drawing(s) do not show
                            receiving surface water(s) and watershed boundaries, if applicable, within the project site
                            and floodway or floodplain. Please address. [25 Pa. Code § 102.4(b)(5)(v)]
                        </label>
                    </div>
                </li>
                <li>
                    <div class="form-group i-checks">
                        <label for="cb-6-e">
                            <input type="checkbox" class="cbi cbic"
                                   value="e. The Drawing(s) do not identify all discharge points.  Please address.  [25 Pa. Code §\r\n        102.4(b)(5)(ix)]"
                                   id="cb-6-e" name="options[][]" data-parent-id="cb-6"> <i class="ml-1"></i>e. The
                            Drawing(s) do not identify
                            all discharge points. Please address. [25 Pa. Code § 102.4(b)(5)(ix)]
                        </label>
                    </div>
                </li>
                <li>
                    <div class="form-group i-checks">
                        <label for="cb-6-f">
                            <input type="checkbox" class="cbi cbic"
                                   value="f. The Drawing(s) do not show the location of all BMPs and drainage areas to the BMPs as\r\n        applicable.  Please address.  [25 Pa. Code § 102.4(b)(5)(vi)]"
                                   id="cb-6-f" name="options[][]" data-parent-id="cb-6"> <i class="ml-1"></i>f. The
                            Drawing(s) do not show the
                            location of all BMPs and drainage areas to the BMPs as applicable. Please address. [25 Pa.
                            Code § 102.4(b)(5)(vi)]
                        </label>
                    </div>
                </li>
                <li>
                    <div class="form-group i-checks">
                        <label for="cb-6-g">
                            <input type="checkbox" class="cbi cbic"
                                   value="g. The Drawing(s) do not show existing and proposed utilities and site improvements.  Please\r\n        address.  [25 Pa. Code § 102.4(b)(5)(iii)]"
                                   id="cb-6-g" name="options[][]" data-parent-id="cb-6"> <i class="ml-1"></i>g. The
                            Drawing(s) do not show
                            existing and proposed utilities and site improvements. Please address. [25 Pa. Code §
                            102.4(b)(5)(iii)]
                        </label>
                    </div>
                </li>
                <li>
                    <div class="form-group i-checks">
                        <label for="cb-6-h">
                            <input type="checkbox" class="cbi cbic"
                                   value="h. The Drawing(s) do not show existing and proposed riparian buffer(s), if applicable.  Please\r\n        address.  [25 Pa. Code § 102.4(b)(5)(xv)]"
                                   id="cb-6-h" name="options[][]" data-parent-id="cb-6"> <i class="ml-1"></i>h. The
                            Drawing(s) do not show
                            existing and proposed riparian buffer(s), if applicable. Please address. [25 Pa. Code §
                            102.4(b)(5)(xv)]
                        </label>
                    </div>
                </li>
                <li>
                    <div class="form-group i-checks">
                        <label for="cb-6-i">
                            <input type="checkbox" class="cbi cbic"
                                   value="i. The Drawing(s) do not show proposed off-site support activities, if applicable.  Please\r\n        address.  [25 Pa. Code § 102.4(b)(5)(iii)]"
                                   id="cb-6-i" name="options[][]" data-parent-id="cb-6"> <i class="ml-1"></i>i. The
                            Drawing(s) do not show
                            proposed off-site support activities, if applicable. Please address. [25 Pa. Code §
                            102.4(b)(5)(iii)]
                        </label>
                    </div>
                </li>
                <li>
                    <div class="form-group i-checks">
                        <label for="cb-6-j">
                            <input type="checkbox" class="cbi cbic"
                                   value="j. The Drawing(s) do not show the Avoidance Measures specified on the signed PNDI\r\n        receipt, if applicable.  Please address.  [25 Pa. Code § 102.4(c)]"
                                   id="cb-6-j" name="options[][]" data-parent-id="cb-6"> <i class="ml-1"></i>j. The
                            Drawing(s) do not show the
                            Avoidance Measures specified on the signed PNDI receipt, if applicable. Please address. [25
                            Pa. Code § 102.4(c)]
                        </label>
                    </div>
                </li>
                <li>
                    <div class="form-group i-checks">
                        <label for="cb-6-k">
                            <input type="checkbox" class="cbi cbic"
                                   value="k. The Drawing(s) do not provide for protection of infiltration PCSM BMPs until drainage\r\n        areas are completely stabilized, if applicable.\r\n        Please address.  [25 Pa. Code § 102.4(b)(5)(vii)]"
                                   id="cb-6-k" name="options[][]" data-parent-id="cb-6"> <i class="ml-1"></i>k. The
                            Drawing(s) do not provide
                            for protection of infiltration PCSM BMPs until drainage areas are completely stabilized, if
                            applicable. Please address. [25 Pa. Code § 102.4(b)(5)(vii)]
                        </label>
                    </div>
                </li>
                <li>
                    <div class="form-group i-checks">
                        <label for="cb-6-l">
                            <input type="checkbox" class="cbi cbic"
                                   value="l. The Drawing(s) do not show the sequence of construction, an operation and maintenance\r\n        (O&M) program, and procedures for recycling or disposing of materials (not necessary if a\r\n        separate narrative is attached).  Please address.  [25 Pa. Code § 102.4(b)(5)(vii) & 102.4(b)\r\n        (5)(xii)\r\n\r"
                                   id="cb-6-l" name="options[][]" data-parent-id="cb-6"> <i class="ml-1"></i>l. The
                            Drawing(s) do not show the
                            sequence of construction, an operation and maintenance (O&M) program, and procedures for
                            recycling or disposing of materials (not necessary if a separate narrative is attached).
                            Please address. [25 Pa. Code § 102.4(b)(5)(vii) & 102.4(b)(5)(xii)
                        </label>
                    </div>
                </li>
            </ol>
        </div>
        <div class="col-md-12">
            <div class="form-group i-checks">
                <label for="cb-7">
                    <input type="checkbox" class="cbi"
                           value="7. Two copies of the complete PCSM Module 2 (3800-PM-BCW0406b) were not submitted\r\n     and were not completed as instructed in the PAG-02 NOI Instructions.\r\n     Please address.  [25 Pa. Code § 102.6(a)(1)]\r"
                           id="cb-7" name="options[]"> <i class="ml-1"></i>7. Two copies of the complete PCSM Module 2
                    (3800-PM-BCW0406b) were not submitted and were not completed as instructed in the PAG-02 NOI
                    Instructions. Please address. [25 Pa. Code § 102.6(a)(1)]
                </label>
            </div>
            <ol class="list-unstyled" style="padding-left: 30px">
                <li>
                    <div class="form-group i-checks">
                        <label for="cb-7-a">
                            <input type="checkbox" class="cbi cbic"
                                   value="a. Details were not provided for all PCSM BMPs (Question 1 of PCSM Plan Information).\r\n        Please address.  [25 Pa. Code § 102.8(f)(9)]"
                                   id="cb-7-a" name="options[][]" data-parent-id="cb-7"> <i class="ml-1"></i>a. Details
                            were not provided for
                            all PCSM BMPs (Question 1 of PCSM Plan Information). Please address. [25 Pa. Code §
                            102.8(f)(9)]
                        </label>
                    </div>
                </li>
                <li>
                    <div class="form-group i-checks">
                        <label for="cb-7-b">
                            <input type="checkbox" class="cbi cbic"
                                   value="b. The project does qualify as a Site Restoration Project.  Please address. [25 Pa. Code §\r\n        102.8(n)"
                                   id="cb-7-b" name="options[][]" data-parent-id="cb-7"> <i class="ml-1"></i>b. The
                            project does qualify as a
                            Site Restoration Project. Please address. [25 Pa. Code § 102.8(n)
                        </label>
                    </div>
                </li>
                <li>
                    <div class="form-group i-checks">
                        <label for="cb-7-c">
                            <input type="checkbox" class="cbi cbic"
                                   value="c. A pre-development site characterization was not provided (i.e., soils and geotechnical\r\n        testing results and narrative of methods and results).\r\n        Please address.  [25 Pa. Code § 102.8(g)\r\n        (1)"
                                   id="cb-7-c" name="options[][]" data-parent-id="cb-7"> <i class="ml-1"></i>c. A
                            pre-development site
                            characterization was not provided (i.e., soils and geotechnical testing results and
                            narrative of methods and results). Please address. [25 Pa. Code § 102.8(g)(1)
                        </label>
                    </div>
                </li>
                <li>
                    <div class="form-group i-checks">
                        <label for="cb-7-d">
                            <input type="checkbox" class="cbi cbic"
                                   value="d. Soil/geologic test results were not attached.   Please address.  [25 Pa. Code § 102.8(g)(1)"
                                   id="cb-7-d" name="options[][]" data-parent-id="cb-7"> <i class="ml-1"></i>d.
                            Soil/geologic test results
                            were not attached. Please address. [25 Pa. Code § 102.8(g)(1)
                        </label>
                    </div>
                </li>
                <li>
                    <div class="form-group i-checks">
                        <label for="cb-7-e">
                            <input type="checkbox" class="cbi cbic"
                                   value="e. Printout of DEP’s PCSM Spreadsheet – Volume Worksheet was not attached. Please\r\n        address. [25 Pa. Code § 102.8(f)(8), 102.8(g)(2) & 102.8(g)(4)"
                                   id="cb-7-e" name="options[][]" data-parent-id="cb-7"> <i class="ml-1"></i>e. Printout
                            of DEP’s PCSM
                            Spreadsheet – Volume Worksheet was not attached. Please address. [25 Pa. Code § 102.8(f)(8),
                            102.8(g)(2) & 102.8(g)(4)
                        </label>
                    </div>
                </li>
                <li>
                    <div class="form-group i-checks">
                        <label for="cb-7-f">
                            <input type="checkbox" class="cbi cbic"
                                   value="f. Stormwater Analysis – Runoff Volume Questions 5 – 9 were not answered and supporting\r\n        calculations were not provided.  Please address.  [25 Pa. Code § 102102.8(f)(8), 102.8(g)(2)\r\n        & 102.8(g)(4)"
                                   id="cb-7-f" name="options[][]" data-parent-id="cb-7"> <i class="ml-1"></i>f.
                            Stormwater Analysis – Runoff
                            Volume Questions 5 – 9 were not answered and supporting calculations were not provided.
                            Please address. [25 Pa. Code § 102102.8(f)(8), 102.8(g)(2) & 102.8(g)(4)
                        </label>
                    </div>
                </li>
                <li>
                    <div class="form-group i-checks">
                        <label for="cb-7-g">
                            <input type="checkbox" class="cbi cbic"
                                   value="g. Printout of DEP’s PCSM Spreadsheet – Rate Worksheet was not attached.   Please\r\n        address.  [25 Pa. Code § 102102.8(f)(8), 102.8(g)(3) & 102.8(g)(4)"
                                   id="cb-7-g" name="options[][]" data-parent-id="cb-7"> <i class="ml-1"></i>g. Printout
                            of DEP’s PCSM
                            Spreadsheet – Rate Worksheet was not attached. Please address. [25 Pa. Code §
                            102102.8(f)(8), 102.8(g)(3) & 102.8(g)(4)
                        </label>
                    </div>
                </li>
                <li>
                    <div class="form-group i-checks">
                        <label for="cb-7-h">
                            <input type="checkbox" class="cbi cbic"
                                   value="h. Stormwater Analysis – Peak Rate Questions 5 – 9 were not answered and supporting\r\n        calculations were not provided. Please address. [25 Pa. Code § 102.8(f)(8), 102.8(g)(3) &\r\n        102.8(g)(4)"
                                   id="cb-7-h" name="options[][]" data-parent-id="cb-7"> <i class="ml-1"></i>h.
                            Stormwater Analysis – Peak
                            Rate Questions 5 – 9 were not answered and supporting calculations were not provided. Please
                            address. [25 Pa. Code § 102.8(f)(8), 102.8(g)(3) & 102.8(g)(4)
                        </label>
                    </div>
                </li>
                <li>
                    <div class="form-group i-checks">
                        <label for="cb-7-i">
                            <input type="checkbox" class="cbi cbic"
                                   value="i. 102.11(b) – If Managed Release Concept (MRC) BMPs were proposed, MRC Design\r\n        Summary Sheets were provided for each BMP and were sealed by a professional engineer.\r\n\r"
                                   id="cb-7-i" name="options[][]" data-parent-id="cb-7"> <i class="ml-1"></i>i. 102.11(b) – If Managed Release Concept (MRC) BMPs were proposed, MRC Design Summary Sheets were provided for each BMP and were sealed by a professional engineer.
                        </label>
                    </div>
                </li>
            </ol>
        </div>
        <div class="col-md-12">
            <div class="form-group i-checks">
                <label for="cb-8">
                    <input type="checkbox" class="cbi"
                           value="8. Two sets or copies of PCSM Plan Drawing(s) were not submitted.\r\n     Please address. [25 Pa. Code § 102.8(f)(9)\r"
                           id="cb-8" name="options[]"> <i class="ml-1"></i>8. Two sets or copies of PCSM Plan
                    Drawing(s) were not submitted. Please address. [25 Pa. Code § 102.8(f)(9)
                </label>
            </div>
            <ol class="list-unstyled" style="padding-left: 30px">
                <li>
                    <div class="form-group i-checks">
                        <label for="cb-8-a">
                            <input type="checkbox" class="cbi cbic"
                                   value="a. The Drawing(s) do not include existing and proposed topography with appropriate contour\r\n        labels. Please address. [25 Pa. Code § 102.8(f)(1)"
                                   id="cb-8-a" name="options[][]" data-parent-id="cb-8"> <i class="ml-1"></i>a. The
                            Drawing(s) do not include existing and proposed topography with appropriate contour labels.
                            Please address. [25 Pa. Code § 102.8(f)(1)
                        </label>
                    </div>
                </li>
                <li>
                    <div class="form-group i-checks">
                        <label for="cb-8-b">
                            <input type="checkbox" class="cbi cbic"
                                   value="b. The Drawing(s) do not include the project site boundary.  Please address. [25 Pa. Code §\r\n        102.8(f)(3)"
                                   id="cb-8-b" name="options[][]" data-parent-id="cb-8"> <i class="ml-1"></i>b. The
                            Drawing(s) do not include the project site boundary. Please address. [25 Pa. Code §
                            102.8(f)(3)
                        </label>
                    </div>
                </li>
                <li>
                    <div class="form-group i-checks">
                        <label for="cb-8-c">
                            <input type="checkbox" class="cbi cbic"
                                   value="c. The Drawing(s) do not include the limit of earth disturbance within the project site.  Please\r\n        address. [25 Pa. Code § 102.8(f)(3)"
                                   id="cb-8-c" name="options[][]" data-parent-id="cb-8"> <i class="ml-1"></i>c. The
                            Drawing(s) do not include the limit of earth disturbance within the project site. Please
                            address. [25 Pa. Code § 102.8(f)(3)
                        </label>
                    </div>
                </li>
                <li>
                    <div class="form-group i-checks">
                        <label for="cb-8-d">
                            <input type="checkbox" class="cbi cbic"
                                   value="d. The Drawing(s) do not show receiving surface water(s) and watershed boundaries, if\r\n        applicable, within the project site and floodway or floodplain.\r\n        Please address. [25 Pa. Code §\r\n        102.8(f)(5)"
                                   id="cb-8-d" name="options[][]" data-parent-id="cb-8"> <i class="ml-1"></i>d. The
                            Drawing(s) do not show receiving surface water(s) and watershed boundaries, if applicable,
                            within the project site and floodway or floodplain. Please address. [25 Pa. Code §
                            102.8(f)(5)
                        </label>
                    </div>
                </li>
                <li>
                    <div class="form-group i-checks">
                        <label for="cb-8-e">
                            <input type="checkbox" class="cbi cbic"
                                   value="e. The Drawing(s) do not identify all discharge points. Please address. [25 Pa. Code §\r\n        102.8(f)(9)"
                                   id="cb-8-e" name="options[][]" data-parent-id="cb-8"> <i class="ml-1"></i>e. The
                            Drawing(s) do not identify all discharge points. Please address. [25 Pa. Code § 102.8(f)(9)
                        </label>
                    </div>
                </li>
                <li>
                    <div class="form-group i-checks">
                        <label for="cb-8-f">
                            <input type="checkbox" class="cbi cbic"
                                   value="f. The Drawing(s) do not show the location of all BMPs with identifiers cross-referenced to\r\n        PCSM Module 2. Please address. [25 Pa. Code § 102.8(f)(6)"
                                   id="cb-8-f" name="options[][]" data-parent-id="cb-8"> <i class="ml-1"></i>f. The
                            Drawing(s) do not show the location of all BMPs with identifiers cross-referenced to PCSM
                            Module 2. Please address. [25 Pa. Code § 102.8(f)(6)
                        </label>
                    </div>
                </li>
                <li>
                    <div class="form-group i-checks">
                        <label for="cb-8-g">
                            <input type="checkbox" class="cbi cbic"
                                   value="g. The Drawing(s) do not show existing and proposed utilities and site improvements. Please\r\n        address. [25 Pa. Code § 102.8(f)(3)"
                                   id="cb-8-g" name="options[][]" data-parent-id="cb-8"> <i class="ml-1"></i>g. The
                            Drawing(s) do not show existing and proposed utilities and site improvements. Please
                            address. [25 Pa. Code § 102.8(f)(3)
                        </label>
                    </div>
                </li>
                <li>
                    <div class="form-group i-checks">
                        <label for="cb-8-h">
                            <input type="checkbox" class="cbi cbic"
                                   value="h. The Drawing(s) do not show existing and proposed riparian buffer(s), if applicable. Please\r\n        address. [25 Pa. Code § 102.8(f)(14)"
                                   id="cb-8-h" name="options[][]" data-parent-id="cb-8"> <i class="ml-1"></i>h. The
                            Drawing(s) do not show existing and proposed riparian buffer(s), if applicable. Please
                            address. [25 Pa. Code § 102.8(f)(14)
                        </label>
                    </div>
                </li>
                <li>
                    <div class="form-group i-checks">
                        <label for="cb-8-i">
                            <input type="checkbox" class="cbi cbic"
                                   value="i. The Drawing(s) do not show proposed off-site support activities, if applicable. Please\r\n        address. [25 Pa. Code § 102.8(f)(3)"
                                   id="cb-8-i" name="options[][]" data-parent-id="cb-8"> <i class="ml-1"></i>i. The
                            Drawing(s) do not show proposed off-site support activities, if applicable. Please address.
                            [25 Pa. Code § 102.8(f)(3)
                        </label>
                    </div>
                </li>
                <li>
                    <div class="form-group i-checks">
                        <label for="cb-8-j">
                            <input type="checkbox" class="cbi cbic"
                                   value="j. The Drawing(s) do not show the Avoidance Measures specified on the signed PNDI\r\n        receipt, if applicable. Please address. [25 Pa. Code § 102.4(c)]"
                                   id="cb-8-j" name="options[][]" data-parent-id="cb-8"> <i class="ml-1"></i>j. The
                            Drawing(s) do not show the Avoidance Measures specified on the signed PNDI receipt, if
                            applicable. Please address. [25 Pa. Code § 102.4(c)]
                        </label>
                    </div>
                </li>
                <li>
                    <div class="form-group i-checks">
                        <label for="cb-8-k">
                            <input type="checkbox" class="cbi cbic"
                                   value="k. The Drawing(s) do not show the sequence of PCSM BMP implementation, a long-term\r\n        operation and maintenance (O&M) schedule, procedures for recycling or disposing of\r\n        materials, and critical stages of BMP implementation (not necessary if a separate narrative\r\n        is attached). Please address. [25 Pa. Code § 102.8(f)(7) & 102.8(f)(10)"
                                   id="cb-8-k" name="options[][]" data-parent-id="cb-8"> <i class="ml-1"></i>k. The
                            Drawing(s) do not show the sequence of PCSM BMP implementation, a long-term operation and
                            maintenance (O&M) schedule, procedures for recycling or disposing of materials, and critical
                            stages of BMP implementation (not necessary if a separate narrative is attached). Please
                            address. [25 Pa. Code § 102.8(f)(7) & 102.8(f)(10)
                        </label>
                    </div>
                </li>
                <li>
                    <div class="form-group i-checks">
                        <label for="cb-8-l">
                            <input type="checkbox" class="cbi cbic"
                                   value="l. The Drawing(s) do not show sensitive features including sinkholes, surface depressions, soil\r\n        contamination hot spots, and wetlands, if applicable.	Please address. [25 Pa. Code §\r\n        102.8(f)(2)"
                                   id="cb-8-l" name="options[][]" data-parent-id="cb-8"> <i class="ml-1"></i>l. The
                            Drawing(s) do not show sensitive features including sinkholes, surface depressions, soil
                            contamination hot spots, and wetlands, if applicable. Please address. [25 Pa. Code §
                            102.8(f)(2)
                        </label>
                    </div>
                </li>
                <li>
                    <div class="form-group i-checks">
                        <label for="cb-8-m">
                            <input type="checkbox" class="cbi cbic"
                                   value="m. The Drawing(s) do not show the location of test pits used for infiltration testing as cross-\r\n        referenced to PCSM Module 2, Infiltration Information.\r\n        Please address. [25 Pa. Code § 102.8(g)(1)\r"
                                   id="cb-8-m" name="options[][]" data-parent-id="cb-8"> <i class="ml-1"></i>m. The
                            Drawing(s) do not show the location of test pits used for infiltration testing as
                            cross-referenced to PCSM Module 2, Infiltration Information. Please address. [25 Pa. Code §
                            102.8(g)(1)
                        </label>
                    </div>
                </li>
            </ol>
        </div>
    </div>
</div>
