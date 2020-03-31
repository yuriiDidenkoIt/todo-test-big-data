import React from 'react';
import { useSelector, useDispatch } from 'react-redux';
import classNames from 'classnames'
import { updateActivePage } from '../redux/actions';
import { getPaginationState } from '../redux/selectors';

import './Pagination.css'

const Pagination = () => {
    const { activePage, totalItemsCount, pageCount } = useSelector(getPaginationState)
    const dispatch = useDispatch();
    const decreasePage = () => activePage > 1 ? dispatch(updateActivePage(activePage - 1)) : null;
    const increasePage = () => (
        activePage < pageCount
            ? dispatch(updateActivePage(activePage + 1))
            : null
    );
    return (
        <div className="pagination-container">
            <div
                children={`Total items: ${totalItemsCount}`}
            />
            <div
                className={classNames("pagination-previous", { disabled: activePage === 1 })}
                children="<"
                onClick={decreasePage}
            />
            <div
                className={classNames("pagination-next", { disabled: activePage >= pageCount })}
                children=">"
                onClick={increasePage}
            />
            <div
                children={`Total pages: ${pageCount}`}
            />
        </div>
    );
}

export default Pagination;