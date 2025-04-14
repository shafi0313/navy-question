<style>
    /* .page-number {
        font-size: 12px;
        text-align: center;
        width: 100%;
        position: absolute;
        top: 40px;
    } */

    /* .rotate {
        transform: rotate(180deg);
        display: inline-block;
    } */
    header {
        margin-top: 30px;
        font-size: 12px;
    }

    .left {
        margin-left: 50px;
        margin-right: 215px;
    }
    .center {
        margin-right: 210px;
    }
</style>

<header>
    <span class="left">{{ $group }}{{ $set }}</span>
    <span class="center">Page <span class="pageNumber"></span> of <span class="totalPages"></span></span>
    <span class="">{{ $group }}{{ $set }}</span>
</header>