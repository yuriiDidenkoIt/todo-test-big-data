import { updateActivePage } from "../redux/actions";

const usePaginationActions = (activePage, pageCount, dispatch) => {
    const toPreviousPage = () => activePage <= 1 || dispatch(updateActivePage(activePage - 1));
    const toNextPage = () => activePage >= pageCount || dispatch(updateActivePage(activePage + 1));
    const toFirstPage = () => dispatch(updateActivePage(1))
    const toLastPage = () => dispatch(updateActivePage(pageCount))

    return { toPreviousPage, toNextPage, toFirstPage, toLastPage }
}

export default usePaginationActions;