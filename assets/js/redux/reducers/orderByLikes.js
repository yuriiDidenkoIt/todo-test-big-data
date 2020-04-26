import { SET_ORDER_BY_LIKES } from "../actionTypes";
import { ORDER_BY_LIKES } from "../../constants";

const initialState = ORDER_BY_LIKES.ASC;

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
