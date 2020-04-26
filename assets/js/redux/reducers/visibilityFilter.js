import { SET_FILTER, SET_COUNTS_ITEMS_BY_FILTER } from "../actionTypes";
import { VISIBILITY_FILTERS_IDS } from "../../constants";

const initialState = {
    filter: VISIBILITY_FILTERS_IDS.ALL,
    counts: {
        [VISIBILITY_FILTERS_IDS.ALL]: 0,
        [VISIBILITY_FILTERS_IDS.NEW]: 0,
        [VISIBILITY_FILTERS_IDS.COMPLETED]: 0,
        [VISIBILITY_FILTERS_IDS.REJECTED]: 0,
        [VISIBILITY_FILTERS_IDS.IN_PROGRESS]: 0,
    }
};

const visibilityFilter = (state = initialState, action) => {
    switch (action.type) {
        case SET_FILTER: {
            return {
                ...state,
                filter: action.payload.filter,
            }
        }
        case SET_COUNTS_ITEMS_BY_FILTER: {
            return {
                ...state,
                counts: action.payload.counts,
            }
        }
        default: {
            return state;
        }
    }
};

export default visibilityFilter;
