import { useState, useEffect } from 'react';
import { useDispatch } from 'react-redux';
import { updateActivePage } from "../redux/actions";

const PAGE_COUNT_ON_THE_PAGE = 10;

function* range(start, end) {
    while (start <= end) {
        yield start;
        start++;
    }
}

const usePaginationSegment = (activePage, pageCount) => {
    const [paginationSegment, setPaginationSegment] = useState({ start: 1, end: PAGE_COUNT_ON_THE_PAGE })
    const dispatch = useDispatch();
    useEffect(() => {
        const { start, end } = paginationSegment;
        if (activePage > end && activePage + PAGE_COUNT_ON_THE_PAGE <= pageCount) {
            setPaginationSegment({ start: activePage, end: activePage + PAGE_COUNT_ON_THE_PAGE })
        }

        if (activePage + PAGE_COUNT_ON_THE_PAGE >= pageCount) {
            setPaginationSegment({ start:pageCount - PAGE_COUNT_ON_THE_PAGE, end: pageCount })
        }

        if (activePage < start && activePage - PAGE_COUNT_ON_THE_PAGE >= 0) {
            setPaginationSegment({ start: activePage - PAGE_COUNT_ON_THE_PAGE || 1, end: activePage })
        }

        if (activePage === pageCount || activePage > pageCount) {
            setPaginationSegment({ start: pageCount - PAGE_COUNT_ON_THE_PAGE, end: pageCount })
            dispatch(updateActivePage(pageCount))
        }
        if (activePage === 1) {
            setPaginationSegment({ start: 1, end: PAGE_COUNT_ON_THE_PAGE })
        }
    }, [activePage, pageCount]);

    return Array.from(range(paginationSegment.start, paginationSegment.end));
}

export default usePaginationSegment;