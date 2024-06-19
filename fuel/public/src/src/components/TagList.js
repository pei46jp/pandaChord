import React from "react";
import { Link } from "react-router-dom";


function TagList({ tags }) {
    return (
        <div className="list-group">
            {tags.map(tag => (
                <Link key={tag.tag_name} to={`/pandachord/tag/${tag.tag_name}`} className="list-group-item list-group-item-action">
                    # {tag.tag_name}
                </Link>
            ))}
        </div>
    );
}

export default TagList;