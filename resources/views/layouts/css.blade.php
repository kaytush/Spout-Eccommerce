<style>
.data-details {
    border-radius: 4px;
    padding: 18px 20px;
    border: 1px solid #d2dde9;
}
.data-details > div {
    flex-grow: 1;
    margin-bottom: 18px;
}
.data-details > div:last-child {
    margin-bottom: 0;
}
.data-details-title {
    font-size: 14px;
    font-weight: 600;
    color: #758698;
    line-height: 20px;
    display: block;
}
.data-details-info {
    font-size: 14px;
    font-weight: 400;
    color: #495463;
    line-height: 20px;
    display: block;
    margin-top: 6px;
}
.data-details-info.large {
    font-size: 20px;
}
.data-details-list {
    border-radius: 4px;
    border: 1px solid #d2dde9;
}
.data-details-list li {
    display: block;
}
.data-details-list li:last-child .data-details-des {
    border-bottom: none;
}
.data-details-head {
    font-size: 13px;
    font-weight: 500;
    color: #758698;
    line-height: 20px;
    padding: 15px 20px 2px;
    width: 100%;
}
.data-details-des {
    font-size: 14px;
    color: #495463;
    font-weight: 400;
    line-height: 20px;
    padding: 2px 20px 15px;
    flex-grow: 1;
    border-bottom: 1px solid #d2dde9;
    display: flex;
    justify-content: space-between;
}
.data-details-des .ti:not([data-toggle="tooltip"]),
.data-details-des [class*="fa"]:not([data-toggle="tooltip"]) {
    color: #1605ff;
}
.data-details-des span:last-child:not(:first-child) {
    font-size: 12px;
    color: #758698;
}
.data-details-des small {
    color: #758698;
}
.data-details-des span,
.data-details-des strong {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.data-details-docs {
    border-top: 1px solid #d2dde9;
    margin-top: 12px;
}
.data-details-docs-title {
    color: #495463;
    display: block;
    padding-bottom: 6px;
    font-weight: 400;
}
.data-details-docs > li {
    flex-grow: 1;
    border-bottom: 1px solid #d2dde9;
    padding: 20px;
}
.data-details-docs > li:last-child {
    border-bottom: none;
}
.data-details-alt {
    border-radius: 4px;
    border: 1px solid #d2dde9;
    font-weight: 400;
}
.data-details-alt li {
    line-height: 1.35;
    padding: 15px 20px;
    border-bottom: 1px solid #d2dde9;
}
.data-details-alt li:last-child {
    border-bottom: none;
}
.data-details-alt li div {
    padding: 3px 0;
}
.data-details-date {
    display: block;
    padding-bottom: 4px;
}
@media (min-width: 576px) {
    .data-details-list > li {
        display: flex;
        align-items: center;
    }
    .data-details-head {
        width: 190px;
        padding: 14px 20px;
    }
    .data-details-des {
        border-top: none;
        border-left: 1px solid #d2dde9;
        width: calc(100% - 190px);
        padding: 14px 20px;
    }
}
</style>
