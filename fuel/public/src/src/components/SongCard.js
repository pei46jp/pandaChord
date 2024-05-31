import React from "react";


function SongCard({ title, memo }) {
    return (
        <div className="col-md-4 col-sm-6 py-2">
            <div className="card">
                <div className="card-body">
                    <h3 className="card-title">{title}</h3>
                    <p className="card-text">{memo}</p>
                    <button className="btn btn-secondary">Let's Sing</button>
                </div>
            </div>
        </div>
    );
}

export default SongCard;