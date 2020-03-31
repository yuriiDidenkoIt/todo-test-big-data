import { SET_ORDER_BY_LIKES } from "../actionTypes";

const initialState = null;

const orderByLikes = (state = initialState, action) => {
    switch (action.type) {
        case SET_ORDER_BY_LIKES: {
            return action.payload.order;
        }
        default: {
            return state;
        }
    }
};

export default orderByLikes;
