import React from 'react';
import classNames from 'classnames';
import usePaginationSegment from '../../hooks/usePaginationSegment';
import { updateActivePage } from '../../redux/actions';

const PaginationSegment = ({ activePage, pageCount, dispatch }) => (
    usePaginationSegment(activePage, pageCount).map((id) => (
        <div
            className={classNames({ 'page-active': id === activePage })}
            children={id}
            onClick={() => dispatch(updateActivePage(id))}
            key={id}
        />
    ))
);

export default PaginationSegment;