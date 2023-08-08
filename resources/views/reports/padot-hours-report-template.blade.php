@extends('reports.app')

@section('title', 'PADOT Hours Report - CDIS Reports')

@push('css')
    <style>
        tbody tr.highlight:nth-child(4n), tr.highlight:nth-child(4n-1) {
            background: rgba(0, 0, 0, .1);
            border-left: 2px solid #1ab394;
        }

        tbody tr.highlight:nth-child(4n-2), tr.highlight:nth-child(4n-3) {

            background: rgba(0, 0, 0, .06);
        }
    </style>
@endpush

@section('heading', 'PADOT HOURS ___ Quarter 20__')

@section('content')
    <table class="table table-borderless">
        <thead>
        <tr>
            <th>Technician:</th>
            <td>Gary</td>
            <td></td>
        </tr>
        </thead>
        <tbody>
        <tr>
            <th>Date</th>
            <th>Hours</th>
            <th>Time Category</th>
        </tr>
        <tr>
            <td>12/04/2013</td>
            <td>0.5</td>
            <td>Admin Review</td>
        </tr>
        <tr class="highlight">
            <td><b>Project:
            </th>
            <td>PADOT 46-3004-0080-1435 Berks Road Pipe</td>
            <td></td>
        </tr>
        <tr class="highlight">
            <td>05/11/2012</td>
            <td>1</td>
            <td>Acknowledged Co-Permittee</td>
        </tr>
        <tr class="highlight">
            <td><b>Project:
            </th>
            <td>PADOT SR 1017 SECTION 86S OVER EAST BRANCH PERKIOMEN CREEK</td>
            <td></td>
        </tr>
        <tr class="highlight">
            <td>06/12/2012</td>
            <td>6</td>
            <td>NPDES Review</td>
        </tr>
        <tr class="highlight">
            <td><b>Project:
            </th>
            <td>PADOT US 422 SCHUYLKILL RIVER CROSSING PROJECT SR 0422 SECTION 4TR</td>
            <td></td>
        </tr>
        <tr class="highlight">
            <td>07/31/2012</td>
            <td>5</td>
            <td>NPDES Review</td>
        </tr>
        <tr class="highlight">
            <td><b>Project:
            </th>
            <td>PADOT US 422 SCHUYLKILL RIVER CROSSING PROJECT SR 0422 SECTION 4TR</td>
            <td></td>
        </tr>
        <tr class="highlight">
            <td>08/29/2012</td>
            <td>5.5</td>
            <td>NPDES Review</td>
        </tr>
        <tr class="highlight">
            <td><b>Project:
            </th>
            <td>PADOT US 422 SCHUYLKILL RIVER CROSSING PROJECT SR 0422 SECTION 4TR</td>
            <td></td>
        </tr>
        <tr class="highlight">
            <td>09/17/2012</td>
            <td>1.5</td>
            <td>E &amp; S Review</td>
        </tr>
        <tr class="highlight">
            <td><b>Project:
            </th>
            <td>PADOT EGYPT ROAD OVER CROSSMAN'S RUN</td>
            <td></td>
        </tr>
        <tr class="highlight">
            <td>09/17/2012</td>
            <td>1</td>
            <td>NPDES Review</td>
        </tr>
        <tr class="highlight">
            <td><b>Project:
            </th>
            <td>PADOT US 422 SCHUYLKILL RIVER CROSSING PROJECT SR 0422 SECTION 4TR</td>
            <td></td>
        </tr>
        <tr class="highlight">
            <td>09/19/2012</td>
            <td>3.5</td>
            <td>NPDES Review</td>
        </tr>
        <tr class="highlight">
            <td><b>Project:
            </th>
            <td>PADOT US 422 SCHUYLKILL RIVER CROSSING PROJECT SR 0422 SECTION 4TR</td>
            <td></td>
        </tr>
        <tr class="highlight">
            <td>09/20/2012</td>
            <td>1</td>
            <td>E &amp; S Review</td>
        </tr>
        <tr class="highlight">
            <td><b>Project:
            </th>
            <td>PADOT EGYPT ROAD OVER CROSSMAN'S RUN</td>
            <td></td>
        </tr>
        <tr class="highlight">
            <td>11/29/2012</td>
            <td>1</td>
            <td>E &amp; S Review</td>
        </tr>
        <tr class="highlight">
            <td><b>Project:
            </th>
            <td>PADOT EGYPT ROAD OVER CROSSMAN'S RUN</td>
            <td></td>
        </tr>
        <tr class="highlight">
            <td>01/22/2013</td>
            <td>3</td>
            <td>E &amp; S Review</td>
        </tr>
        <tr class="highlight">
            <td><b>Project:
            </th>
            <td>PADOT S R 1022 SECTION M11 ECMS 93442</td>
            <td></td>
        </tr>
        <tr class="highlight">
            <td>01/28/2013</td>
            <td>1</td>
            <td>E &amp; S Review</td>
        </tr>
        <tr class="highlight">
            <td><b>Project:
            </th>
            <td>PADOT S R 1022 SECTION M11 ECMS 93442</td>
            <td></td>
        </tr>
        <tr class="highlight">
            <td>02/15/2013</td>
            <td>2</td>
            <td>E &amp; S Review</td>
        </tr>
        <tr class="highlight">
            <td><b>Project:
            </th>
            <td>PADOT S R 1022 SECTION M11 ECMS 93442</td>
            <td></td>
        </tr>
        <tr class="highlight">
            <td>04/25/2013</td>
            <td>4.5</td>
            <td>NPDES Review</td>
        </tr>
        <tr class="highlight">
            <td><b>Project:
            </th>
            <td>PADOT US 422 SCHUYLKILL RIVER CROSSING PROJECT SR 0422 SECTION 4TR</td>
            <td></td>
        </tr>
        <tr class="highlight">
            <td>05/13/2013</td>
            <td>3</td>
            <td>Minor Revision</td>
        </tr>
        <tr class="highlight">
            <td><b>Project:
            </th>
            <td>PADOT US 422 SCHUYLKILL RIVER CROSSING PROJECT SR 0422 SECTION 4TR</td>
            <td></td>
        </tr>
        <tr class="highlight">
            <td>05/15/2013</td>
            <td>3.5</td>
            <td>NPDES Review</td>
        </tr>
        <tr class="highlight">
            <td><b>Project:
            </th>
            <td>PADOT US 422 SCHUYLKILL RIVER CROSSING PROJECT SR 0422 SECTION 4TR</td>
            <td></td>
        </tr>
        <tr class="highlight">
            <td>05/22/2013</td>
            <td>2</td>
            <td>E &amp; S Review</td>
        </tr>
        <tr class="highlight">
            <td><b>Project:
            </th>
            <td>PADOT EGYPT ROAD OVER CROSSMAN'S RUN</td>
            <td></td>
        </tr>
        <tr class="highlight">
            <td>06/20/2013</td>
            <td>4</td>
            <td>E &amp; S Review</td>
        </tr>
        <tr class="highlight">
            <td><b>Project:
            </th>
            <td>PADOT 46-1002-0020-087 BUSTARD ROAD PIPE</td>
            <td></td>
        </tr>
        <tr class="highlight">
            <td>07/30/2013</td>
            <td>2</td>
            <td>E &amp; S Review</td>
        </tr>
        <tr class="highlight">
            <td><b>Project:
            </th>
            <td>PADOT 46-1002-0020-087 BUSTARD ROAD PIPE</td>
            <td></td>
        </tr>
        <tr class="highlight">
            <td>12/20/2013</td>
            <td>1</td>
            <td>E &amp; S Review</td>
        </tr>
        <tr class="highlight">
            <td><b>Project:
            </th>
            <td>PADOT 46-3004-0080-1435 Berks Road Pipe</td>
            <td></td>
        </tr>
        <tr class="highlight">
            <td>12/16/2013</td>
            <td>2</td>
            <td>E &amp; S Review</td>
        </tr>
        <tr class="highlight">
            <td><b>Project:
            </th>
            <td>PADOT 46-3004-0080-1435 Berks Road Pipe</td>
            <td></td>
        </tr>
        <tr class="highlight">
            <td>01/10/2014</td>
            <td>5</td>
            <td>Admin Review</td>
        </tr>
        <tr class="highlight">
            <td><b>Project:
            </th>
            <td>PADOT SR 4044 Section MG1 -</td>
            <td></td>
        </tr>
        <tr class="highlight">
            <td>02/24/2014</td>
            <td>2</td>
            <td>Admin Review</td>
        </tr>
        <tr class="highlight">
            <td><b>Project:
            </th>
            <td>PADOT SR 4044 Section MG1 -</td>
            <td></td>
        </tr>
        <tr class="highlight">
            <td>05/27/2014</td>
            <td>3</td>
            <td>Admin Review</td>
        </tr>
        <tr class="highlight">
            <td><b>Project:
            </th>
            <td>PADOT SR 4044 Section MG1 -</td>
            <td></td>
        </tr>
        <tr class="highlight">
            <td>06/23/2014</td>
            <td>5</td>
            <td>NPDES Review</td>
        </tr>
        <tr class="highlight">
            <td><b>Project:
            </th>
            <td>PADOT SR 4044 Section MG1 -</td>
            <td></td>
        </tr>
        <tr class="highlight">
            <td>06/24/2014</td>
            <td>4</td>
            <td>NPDES Review</td>
        </tr>
        <tr class="highlight">
            <td><b>Project:
            </th>
            <td>PADOT SR 4044 Section MG1 -</td>
            <td></td>
        </tr>
        <tr class="highlight">
            <td>06/25/2014</td>
            <td>4</td>
            <td>NPDES Review</td>
        </tr>
        <tr class="highlight">
            <td><b>Project:
            </th>
            <td>PADOT SR 4044 Section MG1 -</td>
            <td></td>
        </tr>
        <tr class="highlight">
            <td>09/08/2014</td>
            <td>4.5</td>
            <td>NPDES Review</td>
        </tr>
        <tr class="highlight">
            <td><b>Project:
            </th>
            <td>PADOT SR 4044 Section MG1 -</td>
            <td></td>
        </tr>
        <tr class="highlight">
            <td>09/09/2014</td>
            <td>4</td>
            <td>NPDES Review</td>
        </tr>
        <tr class="highlight">
            <td><b>Project:
            </th>
            <td>PADOT SR 4044 Section MG1 -</td>
            <td></td>
        </tr>
        <tr class="highlight">
            <td>01/12/2015</td>
            <td>5</td>
            <td>NPDES Review</td>
        </tr>
        <tr class="highlight">
            <td><b>Project:
            </th>
            <td>PADOT SR 4044 Section MG1 -</td>
            <td></td>
        </tr>
        <tr class="highlight">
            <td>07/18/2016</td>
            <td>3</td>
            <td>Admin Review</td>
        </tr>
        <tr class="highlight">
            <td><b>Project:
            </th>
            <td>PADOT S R 0422, Section M2C at Stowe Interchange</td>
            <td></td>
        </tr>
        <tr class="highlight">
            <td>07/18/2016</td>
            <td>3</td>
            <td>Admin Review</td>
        </tr>
        <tr class="highlight">
            <td><b>Project:
            </th>
            <td>PADOT S R 0422, Section M2C at Stowe Interchange</td>
            <td></td>
        </tr>
        <tr class="highlight">
            <td>07/19/2016</td>
            <td>2</td>
            <td>Admin Review</td>
        </tr>
        <tr class="highlight">
            <td><b>Project:
            </th>
            <td>PADOT S R 0422, Section M2C at Stowe Interchange</td>
            <td></td>
        </tr>
        <tr class="highlight">
            <td>11/17/2016</td>
            <td>13.5</td>
            <td>NPDES Review</td>
        </tr>
        <tr class="highlight">
            <td><b>Project:
            </th>
            <td>PADOT S R 0422, Section M2C at Stowe Interchange</td>
            <td></td>
        </tr>
        <tr class="highlight">
            <td>Project Hours:</td>
            <td>112</td>
            <td></td>
        </tr>
        </tbody>

    </table>
@stop


