import { UPDATE_ACTIVE_PAGE, UPDATE_TOTAL_ITEMS_COUNT } from "../actionTypes";

const initialState = {
    activePage: 1,
    totalItemsCount: 0,
    itemsCountPerPage: 50,
    pageCount: 1,
}

const pagination = (state = initialState, action) => {
    switch (action.type) {
        case UPDATE_ACTIVE_PAGE:
            return {
                ...state,
                activePage: action.payload.activePage,
            }
        case UPDATE_TOTAL_ITEMS_COUNT:
            const { totalItemsCount } = action.payload;
            return {
                ...state,
                totalItemsCount,
                pageCount: Math.ceil(totalItemsCount / state.itemsCountPerPage),
            }
        default:
            return state;
    }
}

export default pagination;